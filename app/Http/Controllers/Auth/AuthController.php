<?php

namespace App\Http\Controllers\Auth;

use App\Models\Role;
use App\Models\User;
use App\Models\PeriodeTa;
use Illuminate\Http\Request;
use App\Models\JadwalSeminar;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function index() {
        $data = [
            'title' => 'Login',
        ];

        return view('auth.login', $data);
    }

    public function authenticate(Request $request)
    {
        $credentials = [
            'username' => $request->username,
            'password' => $request->password
        ];

        if(Auth::guard('web')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('apps.switching')->with('success', 'Login success!');
        }else{
            return back()->with('error', 'Username atau password anda salah!');
        }

    }

    public function switching()
    {
        $user = Auth::guard('web')->user();
        $roles = $user->getRoleNames()->toArray();
        $data = [
            "title" => "Switch",
            'roles'   => $roles,
        ];
        return view('auth.switch', $data);
    }

    public function switcher(Request $request)
    {
        session(['switchRoles' => $request->role]);
        return redirect()->route('apps.dashboard');
    }

    public function logout(Request $request)
    {
        // dd(Auth::user()->token->access_token);
        if (Auth::check()) {
            if (isset(Auth::user()->token)) {
                $response = Http::withOptions(['verify' => false])->withHeaders([
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer '  . Auth::user()->token->access_token
                ])->get('https://sso.poliwangi.ac.id/logout');
            }
        }
        $request->user()->token()->delete();
        Session::flush();  
        Auth::logout();
        return redirect('/');
    }

    // SSO
    public function redirect(){
        $queries = http_build_query([
            'client_id' => config('services.oauth_server.client_id'),
            'redirect_uri' => config('services.oauth_server.redirect'),
            'response_type' => 'code',
        ]);
        return redirect(config('services.oauth_server.uri') . '/oauth/authorize?' . $queries);
    }

    public function callback(Request $request)
    {
        $response = Http::withoutVerifying()->post(config('services.oauth_server.uri') . '/oauth/token', [
            'grant_type' => 'authorization_code',
            'client_id' => config('services.oauth_server.client_id'),
            'client_secret' => config('services.oauth_server.client_secret'),
            'redirect_uri' => config('services.oauth_server.redirect'),
            'code' => $request->code
        ]);
        $response = $response->json();
        if (!isset($response['access_token'])) {
            return redirect()->route('login');
        }
        $this->authAfterSso($response);

		$request->user()->token()->delete();
        $request->user()->token()->create([
            'access_token' => $response['access_token'],
            'expires_in' => $response['expires_in'],
            'refresh_token' => $response['refresh_token']
        ]);

        return redirect()->route('apps.switching');
    }

    protected function authAfterSso($response)
    {
        if (!isset($response['access_token'])) {
            return redirect()->route('login');
        }
        $response = Http::withoutVerifying()->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $response['access_token']
        ])->get(config('services.oauth_server.uri') . '/api/user');
        if ($response->status() === 200) {
            $SSOUser = $response->json();
            $user  =   User::where(['username' => $SSOUser['username']])->first();
            if ($user){
                Auth::login($user,true);
                $user->token()->delete();
                return 0;
            } else {
                $user = User::create([
                    'name' => $SSOUser['name'],
                    'username' => $SSOUser['username'],
                    'email' => $SSOUser['email'],
                    'password' => Hash::make($SSOUser['username']),
                    'image' => 'default.jpg',
                ]);
                $roles = unserialize($SSOUser['role']); 
                foreach ($roles as $roleName) {
                    $formattedRoleName = ucfirst(strtolower($roleName));
                    $role = Role::where('name', $formattedRoleName)->first();
                    if (!$role) {
                        $role = Role::create(['name' => $formattedRoleName]);
                    }
                    $user->assignRole($role);
                }            
                Auth::login($user,true);
                $user->token()->delete();
                return 0;
            }
        } else {
            return redirect()->route('login');
        }
    }
	
	public function refresh(Request $request)
    {
        $response = Http::withoutVerifying()->post(config('services.oauth_server.uri') . '/oauth/token', [
            'grant_type' => 'refresh_token',
            'refresh_token' => $request->user()->token->refresh_token,
            'client_id' => config('services.oauth_server.client_id'),
            'client_secret' => config('services.oauth_server.client_secret'),
            'redirect_uri' => config('services.oauth_server.redirect'),
        ]);
        
        if ($response->status() !== 200) {
            $request->user()->token()->delete();
            return redirect()->route('login')->withStatus('Authorization failed from OAuth server.');
        } else {
            $this->logout($request);
        } 

        $response = $response->json();
        $request->user()->token()->update([
            'access_token' => $response['access_token'],
            'expires_in' => $response['expires_in'],
            'refresh_token' => $response['refresh_token']
        ]);
        return redirect()->route('login');
    }
}
