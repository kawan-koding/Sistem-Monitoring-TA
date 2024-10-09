<?php

namespace App\Http\Controllers\Administrator\PengajuanTA;

use App\Models\Mahasiswa;
use App\Models\TugasAkhir;
use Illuminate\Http\Request;
use App\Models\JadwalSeminar;
use App\Http\Controllers\Controller;
use App\Http\Requests\PengajuanTA\PengajuanTARequest;
use App\Models\BimbingUji;
use App\Models\Dosen;
use App\Models\JenisTa;
use App\Models\KuotaDosen;
use App\Models\PeriodeTa;
use App\Models\Topik;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PengajuanTAController extends Controller
{
    public function index()
    {
        $myId = getInfoLogin()->username;
        $mahasiswa = Mahasiswa::where('nim', $myId)->first();
        $ta = TugasAkhir::with(['jenis_ta', 'topik'])->where('mahasiswa_id', $mahasiswa->id)->first();

        $seminar = null;
        if(isset($ta->id)){

            $seminar = JadwalSeminar::where('tugas_akhir_id', $ta->id)->first();
        }

        if ($seminar) {
            $waktu_sekarang = date('Y-m-d H:i:s');
            $tgl_sekarang = date('Y-m-d');
            $wk = ($seminar->tanggal . ' ' . $seminar->jam_selesai);
            if ($waktu_sekarang > $wk && $tgl_sekarang >= $seminar->tanggal) {
                $waktu = 'selesai';
            } else {
                $waktu = 'tidak selesai';
            }
        } else {
            $waktu = 'seminar tidak ditemukan';
        }

        $data = [
            'title' => 'Pengajuan Tugas Akhir',
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
            'dataTA'   => TugasAkhir::with(['jenis_ta', 'topik'])->where('mahasiswa_id', $mahasiswa->id)->get(),
            'timer' => $waktu,
        ];
        
        return view('administrator.pengajuan-ta.index', $data);
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
            // dd($kuota);
            $dosen[] = (object)[
                'id' => $key->id,
                'nidn' => $key->nidn,
                'nama' => $key->name,
                'name' => $key->name,
                'kuota_pembimbing_1' => ($kuota->pembimbing_1 ?? 0),
                'total_pembimbing_1' => $bimbingUji,
            ];
        }

        $data = [
            'title' => 'Pengajuan Tugas Akhir',
            'dataJenis'   => JenisTa::all(),
            'dataTopik'   => Topik::all(),
            'dataDosen'   => $dosen,
            'dosenKuota'   => $dosen,
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

        // dd(JenisTa::all());

        return view('administrator.pengajuan-ta.partials.form', $data);
    }

    public function store(PengajuanTARequest $request)
    {   
        // dd($request->all());
        try {
            $periode = PeriodeTa::where('is_active', 1)->first();
            $myId = Auth::user()->username;
            $mahasiswa = Mahasiswa::where('nim', $myId)->first();
            $docPemb1 = null;
            $docRing = null;

            $kuota = KuotaDosen::where('dosen_id', $request->pembimbing_1)->where('periode_ta_id', $periode->id)->first();
            $bimbingUji = BimbingUji::with(['tugas_akhir', 'dosen'])->where('jenis', 'pembimbing')->where('urut', 1)->where('dosen_id', $request->pembimbing_1)->whereHas('tugas_akhir', function ($q) use($periode){
                $q->where('periode_ta_id', $periode->id);
            })->count();
            // dd(!is_null($kuota) ? $kuota->pemb_1 : 0);
            if($bimbingUji >= (!is_null($kuota) ? $kuota->pembimbing_1 : 0)){

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
                'jenis_ta_id' => $request->jenis_ta_id,
                'topik_id' => $request->topik,
                'mahasiswa_id' =>$mahasiswa->id,
                'periode_ta_id' => $periode->id,
                'judul' => $request->judul,
                'tipe' => $request->tipe,
                'dokumen_pembimbing_1' => $docPemb1,
                'dokumen_ringkasan' => $docRing,
                'status' => 'draft',
                // 'periode_mulai' => $request->periode_mulai,
                // 'periode_akhir' => $request->periode_akhir,
            ]);

            BimbingUji::create(
                [
                    'tugas_akhir_id' => $result->id,
                    'dosen_id' => $request->pembimbing_1,
                    'jenis' => 'pembimbing',
                    'urut' => 1,
                ]
            );

            return redirect()->route('apps.pengajuan-ta')->with('success', 'Data berhasil ditambahkan');
        } catch (\Exception $e) {

            // dd($e->getMessage());
            return redirect()->route('apps.pengajuan-ta')->with('error', $e->getMessage())->withInput($request->all());
        }
    }

    public function edit(TugasAkhir $pengajuanTA)
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
            // dd($kuota);
            $dosen[] = (object)[
                'id' => $key->id,
                'nidn' => $key->nidn,
                'nama' => $key->name,
                'name' => $key->name,
                'kuota_pembimbing_1' => ($kuota->pembimbing_1 ?? 0),
                'total_pembimbing_1' => $bimbingUji,
            ];
        }

        $data = [
            'title' => 'Pengajuan Tugas Akhir',
            'dataJenis'   => JenisTa::all(),
            'dataTopik'   => Topik::all(),
            'dataDosen'   => $dosen,
            'dosenKuota'   => $dosen,
            'editedData' => $pengajuanTA,
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

        // dd(JenisTa::all());

        return view('administrator.pengajuan-ta.partials.form', $data);
    }
}
