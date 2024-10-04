<?php

namespace App\Http\Controllers\Administrator\PengajuanTA;

use App\Models\Mahasiswa;
use App\Models\TugasAkhir;
use Illuminate\Http\Request;
use App\Models\JadwalSeminar;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PengajuanTAController extends Controller
{
    public function index()
    {
        // $myId = Auth::guard('web')->user()->username;
        // $mahasiswa = Mahasiswa::where('nim', $myId)->first();
        // $ta = TugasAkhir::with(['jenis_ta', 'topik'])->where('mahasiswa_id', $mahasiswa->id)->first();

        // $seminar = null;
        // if(isset($ta->id)){

        //     $seminar = JadwalSeminar::where('tugas_akhir_id', $ta->id)->first();
        // }

        // if ($seminar) {
        //     $waktu_sekarang = date('Y-m-d H:i:s');
        //     $tgl_sekarang = date('Y-m-d');
        //     $wk = ($seminar->tanggal . ' ' . $seminar->jam_selesai);
        //     if ($waktu_sekarang > $wk && $tgl_sekarang >= $seminar->tanggal) {
        //         $waktu = 'selesai';
        //     } else {
        //         $waktu = 'tidak selesai';
        //     }
        // } else {
        //     $waktu = 'seminar tidak ditemukan';
        // }

        $data = [
            'title' => 'Pengajuan Tugas Akhir',
            'mods' => 'pengajuan_ta',
            'breadcrumbs' => [
                [
                    'title' => 'Dashboard',
                    'url' => route('apps.dashboard')
                ],
                [
                    'title' => 'Tugas Akhir',
                    'is_active' => true
                ],[
                    'title' => 'Pengajuan Tugas Akhir',
                    'is_active' => true
                ]
            ],
            // 'timer' => $waktu,
            // 'data' => TugasAkhir::with(['jenis_ta', 'topik'])->where('mahasiswa_id', $mahasiswa->id)->get(),
        ];
        
        return view('administrator.pengajuan-ta.index', $data);

        // return view('mahasiswa-menu.pengajuan.index', [
        //     "title" => "Pengajuan TA",
        //     "breadcrumb1" => "Pengajuan TA",
        //     "breadcrumb2" => "Index",
        //     'dataTA'   => TugasAkhir::with(['jenis_ta', 'topik'])->where('mahasiswa_id', $mahasiswa->id)->get(),
        //     'timer' => $waktu,
        //     'jsInit'      => 'js_jadwal_bimbingan_mahasiswa.js',
        // ]);
    }

    public function create()
    {
        $periode = PeriodeTa::where('is_active', 1)->first();
        $dataDosen = Dosen::all();
        $dosen = [];
        foreach ($dataDosen as $key) {
            # code...
            $kuota = KuotaDosen::where('dosen_id', $key->id)->where('periode_ta_id', $periode->id)->first();
            $bimbingUji = BimbingUji::with(['tugas_akhir', 'dosen'])->where('dosen_id', $key->id)->where('jenis', 'pembimbing')->where('urut', 1)->whereHas('tugas_akhir', function ($q) use($periode){
                $q->where('periode_ta_id', $periode->id);
            })->count();
            $dosen[] = (object)[
                'id' => $key->id,
                'nidn' => $key->nidn,
                'nama' => $key->name,
                'name' => $key->name,
                'kuota_pemb_1' => ($kuota->pemb_1 ?? 0),
                'total_pemb_1' => $bimbingUji,
            ];
        }

        $data = [
            'title' => 'Pengajuan Tugas Akhir',
            'dataJenis'   => JenisTa::all(),
            'dataTopik'   => Topik::all(),
            'dataDosen'   => $dosen,
            'dosenKuota'   => $dosen,
            'mods' => 'pengajuan_ta',
            'breadcrumbs' => [
                [
                    'title' => 'Dashboard',
                    'url' => route('apps.dashboard')
                ],
                [
                    'title' => 'Tugas Akhir',
                    'is_active' => true
                ],
                [
                    'title' => 'Pengajuan Tugas Akhir',
                    'is_active' => true
                ]
            ],
        ];

        return view('administrator.pengajuan-ta.form', $data);
    }

    public function store(Request $request)
    {
        try {

            $rules = [
                // 'dokumen_pembimbing_1' => 'required|mimes:pdf,docx',
                'dokumen_ringkasan' => 'required|mimes:docx,pdf',
            ];

            $messages = [
                // 'dokumen_pembimbing_1.required' => 'Dokumen pembimbing 1 tidak boleh kosong!',
                'dokumen_ringkasan.required' => 'Dokumen ringkasan tidak boleh kosong!',
                'dokumen_ringkasan.mimes' => 'Dokumen ringkasan harus dalam format PDF atau DOCX.',
                'dokumen_pembimbing_1.mimes' => 'Dokumen pembimbing 1 harus dalam format PDF atau DOCX.',
            ];

            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput($request->all())->with('gagal', 'Anda gagal menambahkan data!!');
            }

            $periode = PeriodeTa::where('is_active', 1)->first();
            $myId = Auth::guard('web')->user()->username;
            $mahasiswa = Mahasiswa::where('nim', $myId)->first();
            $docPemb1 = null;
            $docRing = null;

            $kuota = KuotaDosen::where('dosen_id', $request->pemb_1)->where('periode_ta_id', $periode->id)->first();
            $bimbingUji = BimbingUji::with(['tugas_akhir', 'dosen'])->where('jenis', 'pembimbing')->where('urut', 1)->where('dosen_id', $request->pemb_1)->whereHas('tugas_akhir', function ($q) use($periode){
                $q->where('periode_ta_id', $periode->id);
            })->count();

            if($bimbingUji >= $kuota->pemb_1){

                return redirect()->back()->with('error', 'Kuota dosen pembimbing 1 yang di pilih telah mencapai batas');

            }

            if(isset($request->dokumen_pembimbing_1)){
                $docPemb1 = $request->dokumen_pembimbing_1->getClientOriginalName() . '-' . time() . '.' . $request->dokumen_pembimbing_1->extension();
                $request->dokumen_pembimbing_1->move(public_path('dokumen'), $docPemb1);
                // dd(1);
            }

            if(isset($request->dokumen_ringkasan)){
                $docRing = $request->dokumen_ringkasan->getClientOriginalName() . '-' . time() . '.' . $request->dokumen_ringkasan->extension();
                $request->dokumen_ringkasan->move(public_path('dokumen'), $docRing);
                // dd(1);
            }

            $result = TugasAkhir::create([
                'jenis_ta_id' => $request->jenis,
                'topik_id' => $request->topik,
                'mahasiswa_id' =>$mahasiswa->id,
                'periode_ta_id' => $periode->id,
                'judul' => $request->judul,
                'tipe' => $request->tipe,
                'dokumen_pemb_1' => $docPemb1,
                'dokumen_ringkasan' => $docRing,
                'status' => 'draft',
                'periode_mulai' => $request->periode_mulai,
                'periode_akhir' => $request->periode_akhir,
            ]);

            BimbingUji::create(
                [
                    'tugas_akhir_id' => $result->id,
                    'dosen_id' => $request->pemb_1,
                    'jenis' => 'pembimbing',
                    'urut' => 1,
                ]
            );

            return redirect()->route('mahasiswa.pengajuan-ta')->with('success', 'Data berhasil ditambahkan');
        } catch (\Exception $e) {

            // dd($e->getMessage());
            return redirect()->route('mahasiswa.pengajuan-ta')->with('error', $e->getMessage())->withInput($request->all());
        }
    }
}
