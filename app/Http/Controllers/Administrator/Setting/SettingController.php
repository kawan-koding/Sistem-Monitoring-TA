<?php

namespace App\Http\Controllers\Administrator\Setting;

use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use File;
class SettingController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Pengaturan Aplikasi',
            'mods' => 'setting',
            'breadcrumbs' => [
                [
                    'title' => 'Dashboard',
                    'url' => route('apps.dashboard')
                ],
                [
                    'title' => 'Pengaturan',
                    'is_active' => true
                ],
                [
                    'title' => 'Aplikasi',
                    'is_active' => true
                ],
            ],
            'data' => Setting::all(),
        ];

        return view('administrator.setting.index', $data);
    }

    public function show(Setting $setting)
    {
        return response()->json($setting);
    }

    public function update(Request $request, Setting $setting)
    {
        $request->validate([
            'value' => $setting->type != 'file' ? 'required' : 'nullable',
            'file' => $setting->type == 'file' ? 'required|mimes:jpg,jpeg,png,gif' : 'nullable' 
        ]);

        try {
          if($setting->type == 'file') {
                if($request->has('file')) {
                    $file = $request->file('file');
                    $filename = time() .'_'. rand(0, 9999999) .'.'. $file->getClientOriginalExtension();
                    $file->move(public_path('storage/images/settings'), $filename);
                    if(file_exists(public_path('storage/images/settings/'. $setting->value) && $setting->value !== 'poliwangi.png')) {
                        File::delete(public_path('storage/images/settings/'. $setting->value));
                    }
                    $request->merge(['value' => $filename]);
                }
            }
            $setting->update(['value' => $request->value]);
            return redirect()->back()->with('success', 'Pengaturan berhasil diperbarui');
        } catch(\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
