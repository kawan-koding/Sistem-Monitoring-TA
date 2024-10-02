<?php

namespace App\Http\Controllers;

use App\Models\User;
// use App\Models\Employee;
use Illuminate\Http\Request;
// use App\Models\Student;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;


class OAuthController extends Controller
{
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
        $test = $this->authAfterSso($response);
        
        if (!isset($test)) {
            // return redirect()->route('login');
        }
		$request->user()->token()->delete();
		
        $request->user()->token()->create([
            'access_token' => $response['access_token'],
            'expires_in' => $response['expires_in'],
            'refresh_token' => $response['refresh_token']
        ]);

        return redirect()->route('admin.switching');
    }

    protected function authAfterSso($response){
        //dd($response);
        if (!isset($response['access_token'])) {
            return redirect()->route('login');
        }
        $response = Http::withoutVerifying()->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $response['access_token']
        ])->get(config('services.oauth_server.uri') . '/api/user');

        if ($response->status() === 200) {
            $SSOUser = $response->json();
            // dd($SSOUser);
        } else return redirect()->route('login');
		
        $users  =   User::where(['username' => $SSOUser['username']])->first();
        // dd($users);
        if(isset($users->id)){
			Auth::login($users,true);
			Session::flush();        
			Auth::logout();
            Auth::login($users,true);
            $users->token()->delete();
            return 0;
        }else if(empty($users)){
            $users = User::create([
                'name' => $SSOUser['name'],
                'username' => $SSOUser['username'],
                'email' => $SSOUser['email'],
                'password' => Hash::make($SSOUser['username']),
                'picture' => 'default.jpg',
            ]);
            Auth::login($users,true);
            $users->token()->delete();
            return 0;
            return null;
        }
		
        
    }
	
	public function refresh(Request $request)
    {
        //dd($request->user()->token->refresh_token);
        $response = Http::withoutVerifying()->post(config('services.oauth_server.uri') . '/oauth/token', [
            'grant_type' => 'refresh_token',
            'refresh_token' => $request->user()->token->refresh_token,
            'client_id' => config('services.oauth_server.client_id'),
            'client_secret' => config('services.oauth_server.client_secret'),
            'redirect_uri' => config('services.oauth_server.redirect'),
        ]);
        //dd($response);
        if ($response->status() !== 200) {
            $request->user()->token()->delete();

            return redirect()->route('login')
                ->withStatus('Authorization failed from OAuth server.');
        }else $this->ssoLogout($request);

        $response = $response->json();
        $request->user()->token()->update([
            'access_token' => $response['access_token'],
            'expires_in' => $response['expires_in'],
            'refresh_token' => $response['refresh_token']
        ]);

        return redirect()->route('login');
    }
}