<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\JadwalSeminar;
use App\Models\PeriodeTa;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function index() {
        // dd(env("OAUTH_SERVER_ID"));
        return view('auth.login', [
            "title" => "Login"
        ]);
    }
    public function portal() {
        $periode = PeriodeTa::where('is_active', 1)->first();
        $jadwal = JadwalSeminar::with(['tugas_akhir', 'ruangan'])->whereHas('tugas_akhir', function($q)use($periode){
            $q->where('periode_ta_id', $periode->id);
        })->get();
        // dd($jadwal);
        return view('auth.portal', [
            "title" => "Portal",
            "jadwal" => $jadwal,
        ]);
    }

    public function authenticate(Request $request)
    {
        // dd($request);
        $credentials = [
            'username' => $request->username,
            'password' => $request->password
        ];

        if(Auth::guard('web')->attempt($credentials)) {
            $request->session()->regenerate();
            // session(['switchRoles' => 'admin']);
            // dd();
            return redirect()->route('admin.switching')->with('success', 'Login success!');
        }else{
            return back()->with('error', 'Sorry the credentials you are using are invalid!');
        }

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
        // $request->session()->invalidate();

        // $request->session()->regenerateToken();

        return redirect('/');
    }
}
