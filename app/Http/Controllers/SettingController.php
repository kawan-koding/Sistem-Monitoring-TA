<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Setting;

class SettingController extends Controller
{
    //
    public function index()
    {
        return view('setting.index', [
            "title" => "Pengaturan",
            "breadcrumb1" => "Umum",
            "breadcrumb2" => "Index",
            "logo" => Setting::where('options', 'profile')->where('label', 'logo')->first(),
            "icon" => Setting::where('options', 'profile')->where('label', 'icon')->first(),
            "name" => Setting::where('options', 'profile')->where('label', 'name')->first(),
            "telephone" => Setting::where('options', 'profile')->where('label', 'telephone')->first(),
            "address" => Setting::where('options', 'profile')->where('label', 'address')->first(),
            'jsInit'      => null,
        ]);
    }

    public function store(Request $request)
    {
        try{

            $rules = [
                'logo' => 'mimes:jpg,jpeg,png',
                'icon' => 'mimes:jpg,jpeg,png',
            ];

            $messages = [
                'icon.mimes' => 'Format tidak mendukung untuk gambar.',
                'logo.mimes' => 'Format tidak mendukung untuk gambar.',
            ];

            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput($request->all())->with('error', 'Anda gagal menambahkan data!!');
            }
            $icon = null;
            if(isset($request->icon)){
                $icon = $request->icon->getClientOriginalName() . '-' . time() . '.' . $request->icon->extension();
                $request->icon->move(public_path('images'), $icon);
                // dd(1);
            }
            $logo = null;
            if(isset($request->logo)){
                $logo = $request->logo->getClientOriginalName() . '-' . time() . '.' . $request->logo->extension();
                $request->logo->move(public_path('images'), $logo);
                // dd(1);
            }
            if (isset($logo)) {
                # code...
                $log = Setting::where('options', 'profile')->where('label', 'logo')->first();
                if(!isset($log)){
                    Setting::create([
                        'groups' => 'general',
                        'options' => 'profile',
                        'label' => 'logo',
                        'value' => $logo,
                        'is_default' => 1,
                        'display_suffix' => "-",
                    ]);
                }else{
                    Setting::where('options', 'profile')->where('label', 'logo')->update([
                        'value' => $logo,
                    ]);
                }
            }
            if (isset($icon)) {
                $ic = Setting::where('options', 'profile')->where('label', 'icon')->first();
                if(!isset($ic)){
                    Setting::create([
                        'groups' => 'general',
                        'options' => 'profile',
                        'label' => 'icon',
                        'value' => $icon,
                        'is_default' => 1,
                        'display_suffix' => "-",
                    ]);
                }else{
                    Setting::where('options', 'profile')->where('label', 'icon')->update([
                        'value' => $icon,
                    ]);
                }
            }
            $nam = Setting::where('options', 'profile')->where('label', 'name')->first();
            if(!isset($nam)){
                Setting::create([
                    'groups' => 'general',
                    'options' => 'profile',
                    'label' => 'name',
                    'value' => $request->name,
                    'is_default' => 1,
                    'display_suffix' => "-",
                ]);
            }else{
                Setting::where('options', 'profile')->where('label', 'name')->update([
                    'value' => $request->name,
                ]);
            }
            $tel = Setting::where('options', 'profile')->where('label', 'telephone')->first();
            if(!isset($tel)){
                Setting::create([
                    'groups' => 'general',
                    'options' => 'profile',
                    'label' => 'telephone',
                    'value' => $request->telephone,
                    'is_default' => 1,
                    'display_suffix' => "-",
                ]);
            }else{
                Setting::where('options', 'profile')->where('label', 'telephone')->update([
                    'value' => $request->telephone,
                ]);
            }
            $addr = Setting::where('options', 'profile')->where('label', 'address')->first();
            if(!isset($addr)){
                Setting::create([
                    'groups' => 'general',
                    'options' => 'profile',
                    'label' => 'address',
                    'value' => $request->address,
                    'is_default' => 1,
                    'display_suffix' => "-",
                ]);
            }else{
                Setting::where('options', 'profile')->where('label', 'address')->update([
                    'value' => $request->address,
                ]);
            }

            return redirect()->route('admin.settings')->with('success', 'Profile berhasil ditambahkan');
        }catch(\Exception $e){
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
