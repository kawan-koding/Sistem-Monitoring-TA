<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\JadwalSeminar;
use App\Models\PeriodeTa;
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
            return back()->with('error', 'Sorry the credentials you are using are invalid!');
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
                // dd($response->status());
            }
        }
        $request->user()->token()->delete();
        Session::flush();  
        Auth::logout();
        return redirect('/');
    }
}
