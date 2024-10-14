<?php

namespace App\Http\Controllers\Administrator\DaftarTA;

use App\Models\Dosen;
use App\Models\Topik;
use App\Models\JenisTa;
use App\Models\PeriodeTa;
use App\Models\BimbingUji;
use App\Models\KuotaDosen;
use App\Models\TugasAkhir;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DaftarTAController extends Controller
{
    public function index()
    {
        $periode = PeriodeTa::where('is_active', 1)->first();
        $dataTa = TugasAkhir::with(['mahasiswa','bimbing_uji','periode_ta','topik','jenis_ta'])->where('periode_ta_id', $periode->id);    
        if (getInfoLogin()->hasRole('Admin')) {
            $dataTa->where('status', '!=', 'draft');
        }
        $dataTa = $dataTa->get();
        $data = [
            'title' => 'Daftar Tugas Akhir',
            'mods' => 'daftar_ta',
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
                    'title' => 'Daftar Tugas Akhir',
                    'is_active' => true
                ]
            ],
            'data' => $dataTa,
        ];
        
        return view('administrator.daftar-ta.index', $data);
    }

    public function show(TugasAkhir $tugasAkhir)
    {
         $data = [
            'title' => 'Detail  Tugas Akhir',
            'mods' => 'daftar_ta',
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
                    'title' => 'Daftar Tugas Akhir',
                    'url' => route('apps.daftar-ta')
                ],
                [
                    'title' => 'Detail Tugas Akhir',
                    'is_active' => true
                ]
            ],
            'data' => [],
        ];
        
        return view('administrator.daftar-ta.index', $data);
    }

    public function edit(TugasAkhir $tugasAkhir)
    {
        $remapped = clone $tugasAkhir; 
        $remapped->load('mahasiswa','bimbing_uji','periode_ta','topik','jenis_ta');
        $pemb1 = $remapped->bimbing_uji()->where('urut', 1)->where('jenis','pembimbing')->first();
        $pemb2 = $remapped->bimbing_uji()->where('urut', 2)->where('jenis','pembimbing')->first();
        $peng1 = $remapped->bimbing_uji()->where('urut', 1)->where('jenis','penguji')->first();
        $peng2 = $remapped->bimbing_uji()->where('urut', 2)->where('jenis','penguji')->first();

        $bimbingUji = $tugasAkhir->bimbing_uji;
        $pembimbing = $bimbingUji->where('jenis', 'pembimbing')->sortBy('urut')->values();
        $penguji = $bimbingUji->where('jenis', 'penguji')->sortBy('urut')->values();
        $periode = PeriodeTa::where('is_active', true)->first();
        $dosen = Dosen::all()->map(function($dosen) use ($periode) {
            $kuota = KuotaDosen::where('dosen_id', $dosen->id)->where('periode_ta_id', $periode->id)->first();
            $totalPembimbing1 = BimbingUji::where('dosen_id', $dosen->id)->where('jenis', 'pembimbing')->where('urut', 1)->whereHas('tugas_akhir', function($query) use ($periode) {
                                    $query->where('periode_ta_id', $periode->id);
                                })->count();
            $totalPembimbing2 = BimbingUji::where('dosen_id', $dosen->id)->where('jenis', 'pembimbing')->where('urut', 2)->whereHas('tugas_akhir', function($query) use ($periode) {
                                    $query->where('periode_ta_id', $periode->id);
                                })->count();
            $totalPenguji1 = BimbingUji::where('dosen_id', $dosen->id)->where('jenis', 'penguji')->where('urut', 1)->whereHas('tugas_akhir', function($query) use ($periode) {
                                $query->where('periode_ta_id', $periode->id);
                            })->count();
            $totalPenguji2 = BimbingUji::where('dosen_id', $dosen->id)->where('jenis', 'penguji')->where('urut', 2)->whereHas('tugas_akhir', function($query) use ($periode) {
                                $query->where('periode_ta_id', $periode->id);
                            })->count();
            return (object)[
                'id' => $dosen->id,
                'nama' => $dosen->name,
                'kuota_pemb_1' => $kuota->pembimbing_1 ?? 0,
                'kuota_pemb_2' => $kuota->pembimbing_2 ?? 0,
                'kuota_peng_1' => $kuota->penguji_1 ?? 0,
                'kuota_peng_2' => $kuota->penguji_2 ?? 0,
                'total_pemb_1' => $totalPembimbing1,
                'total_pemb_2' => $totalPembimbing2,
                'total_peng_1' => $totalPenguji1,
                'total_peng_2' => $totalPenguji2,
                'sisa_pemb_1' => max(0, ($kuota->pembimbing_1 ?? 0) - $totalPembimbing1),
                'sisa_pemb_2' => max(0, ($kuota->pembimbing_2 ?? 0) - $totalPembimbing2),
                'sisa_peng_1' => max(0, ($kuota->penguji_1 ?? 0) - $totalPenguji1),
                'sisa_peng_2' => max(0, ($kuota->penguji_2 ?? 0) - $totalPenguji2),
            ];
        });
        // dd($dosen);

        $data = [
            'title' => 'Edit Tugas Akhir',
            'mods' => 'daftar_ta',
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
                    'title' => 'Daftar Tugas Akhir',
                    'url' => route('apps.daftar-ta')
                ],
                [
                    'title' => 'Edit Tugas Akhir',
                    'is_active' => true
                ]
            ],
            'pembimbing' => $pembimbing,
            'penguji' => $penguji,
            'dosen' => $dosen,
            'data' => $remapped,
            'pemb1' => $pemb1,
            'pemb2' => $pemb2,
            'peng1' => $peng1,
            'peng2' => $peng2,
            'jenis' => JenisTa::all(),
            'topik' => Topik::all(),
            'action' => route('apps.daftar-ta.update', $tugasAkhir->id),
        ];
        
        return view('administrator.daftar-ta.form', $data);
    }

    public function update(Request $request, TugasAkhir $tugasAkhir)
    {
        $request->validate([
            'judul' => 'required',
            'pembimbing_1' => 'required',
            'pembimbing_2' => 'required',
            'penguji_1' => 'required',
            'penguji_2' => 'required',
            'jenis_ta' => 'required',
            'topik' => 'required',
            'tipe' => 'required',
            'doc_pemb_1' => 'nullable|mimes:pdf,docx,doc|max:5120',
            'doc_ringkasan' => 'nullable|mimes:docx,pdf|max:5120',
        ],[
            'judul' => 'Judul Tugas Akhir harus diisi.',
            'pembimbing_1' => 'Pembimbing 1 harus diisi.',
            'pembimbing_2' => 'Pembimbing 2 harus diisi.',
            'penguji_1' => 'Penguji 1 harus diisi.',
            'penguji_2' => 'Penguji 2 harus diisi.',
            'jenis_ta.required' => 'Jenis Tugas Akhir harus diisi.',
            'topik.required' => 'Topik harus diisi.',
            'tipe.required' => 'Tipe harus diisi.',
            'doc_ringkasan.max' => 'Dokumen ringkasan maksimal 5 MB.',
            'doc_pemb_1.max' => 'Dokumen pembimbing 1 maksimal 5 MB.',
            'doc_pemb_1.mimes' => 'Dokumen pembimbing 1 harus dalam format PDF atau DOCX.',
            'doc_ringkasan.mimes' => 'Dokumen ringkasan harus dalam format PDF atau DOCX.',
        ]);

        try {
            $kuota = KuotaDosen::where('dosen_id', $request->pembimbing_1)->where('periode_ta_id', $tugasAkhir->periode_ta_id)->first();
            $validasiData = [
                ['tipe' => 'pembimbing', 'urut' => 1, 'dosen_id' => $request->pembimbing_1, 'kuota' => $kuota->pembimbing_1],
                ['tipe' => 'pembimbing', 'urut' => 2, 'dosen_id' => $request->pembimbing_2, 'kuota' => $kuota->pembimbing_2],
                ['tipe' => 'penguji', 'urut' => 1, 'dosen_id' => $request->penguji_1, 'kuota' => $kuota->penguji_1],
                ['tipe' => 'penguji', 'urut' => 2, 'dosen_id' => $request->penguji_2, 'kuota' => $kuota->penguji_2],
            ];

            foreach ($validasiData as $validasi) {
                $bimbingUji = BimbingUji::with(['tugas_akhir', 'dosen'])
                    ->where('jenis', $validasi['tipe'])
                    ->where('urut', $validasi['urut'])
                    ->where('dosen_id', $validasi['dosen_id'])
                    ->whereHas('tugas_akhir', function ($q) use ($tugasAkhir) {
                        $q->where('periode_ta_id', $tugasAkhir->periode_ta_id);
                    })
                    ->count();
                if ($bimbingUji >= $validasi['kuota']) {
                    return redirect()->back()->with('error', 'Kuota untuk dosen ' . $validasi['tipe'] . ' ' . $validasi['urut'] . ' telah penuh.');
                }
            }

            // $bimbingUji = BimbingUji::with(['tugas_akhir', 'dosen'])->where('jenis', 'pembimbing')->where('urut', 1)
            // ->where('dosen_id', $request->pembimbing_1)->whereHas('tugas_akhir', function ($q) use($ta){
            //     $q->where('periode_ta_id', $tugasAkhir->periode_ta_id);
            // })->count();
            // if($bimbingUji >= $kuota->pemb_1){
            //     return redirect()->back()->with('error', 'Kuota dosen pembimbing 1 yang di pilih telah mencapai batas');
            // }
            // $bimbingUji2 = BimbingUji::with(['tugas_akhir', 'dosen'])->where('jenis', 'pembimbing')->where('urut', 2)
            // ->where('dosen_id', $request->pembimbing_2)->whereHas('tugas_akhir', function ($q) use($ta){
            //     $q->where('periode_ta_id', $ta->periode_ta_id);
            // })->count();
            // if($bimbingUji2 >= $kuota->pemb_2){
            //     return redirect()->back()->with('error', 'Kuota dosen pembimbing 2 yang di pilih telah mencapai batas');
            // }
            // $bimbingUji3 = BimbingUji::with(['tugas_akhir', 'dosen'])->where('jenis', 'penguji')->where('urut', 1)
            // ->where('dosen_id', $request->penguji_1)->whereHas('tugas_akhir', function ($q) use($ta){
            //     $q->where('periode_ta_id', $ta->periode_ta_id);
            // })->count();
            // if($bimbingUji3 >= $kuota->penguji_1){
            //     return redirect()->back()->with('error', 'Kuota dosen penguji 1 yang di pilih telah mencapai batas');
            // }
            // $bimbingUji4 = BimbingUji::with(['tugas_akhir', 'dosen'])->where('jenis', 'penguji')->where('urut', 2)
            // ->where('dosen_id', $request->penguji_2)->whereHas('tugas_akhir', function ($q) use($ta){
            //     $q->where('periode_ta_id', $ta->periode_ta_id);
            // })->count();
            // if($bimbingUji4 >= $kuota->penguji_2){
            //     return redirect()->back()->with('error', 'Kuota dosen penguji 2 yang di pilih telah mencapai batas');
            // }

            // if($ta->status == 'reject'){
            //     $status = 'draft';
            // }else{
            //     $status = $ta->status;
            // }

            // if(isset($request->dokumen_pembimbing_1)){
            //     $docPemb1 = $request->dokumen_pembimbing_1->getClientOriginalName() . '-' . time() . '.' . $request->dokumen_pembimbing_1->extension();
            //     $request->dokumen_pembimbing_1->move(public_path('dokumen'), $docPemb1);
            //     // dd(1);
            // }

            // if(isset($request->dokumen_ringkasan)){
            //     $docRing = $request->dokumen_ringkasan->getClientOriginalName() . '-' . time() . '.' . $request->dokumen_ringkasan->extension();
            //     $request->dokumen_ringkasan->move(public_path('dokumen'), $docRing);
            //     // dd(1);
            // }

            // $result = TugasAkhir::where('id', $id)->update([
            //     'jenis_ta_id' => $request->jenis,
            //     'topik_id' => $request->topik,
            //     'judul' => $request->judul,
            //     'tipe' => $request->tipe,
            //     'dokumen_pemb_1' => $docPemb1,
            //     'dokumen_ringkasan' => $docRing,
            //     'status' => $status,
            //     'periode_mulai' => $request->periode_mulai,
            //     'periode_akhir' => $request->periode_akhir,
            // ]);

            // BimbingUji::where('tugas_akhir_id', $id)->where('jenis', 'pembimbing')->where('urut', 1)->update(
            //     [
            //         'dosen_id' => $request->pemb_1,
            //     ]
            // );
            // BimbingUji::where('tugas_akhir_id', $id)->where('jenis', 'pembimbing')->where('urut', 2)->update(
            //     [
            //         'dosen_id' => $request->pemb_2,
            //     ]
            // );
            // BimbingUji::where('tugas_akhir_id', $id)->where('jenis', 'penguji')->where('urut', 1)->update(
            //     [
            //         'dosen_id' => $request->peng_1,
            //     ]
            // );
            // BimbingUji::where('tugas_akhir_id', $id)->where('jenis', 'penguji')->where('urut', 2)->update(
            //     [
            //         'dosen_id' => $request->peng_2,
            //     ]
            // );
            // return redirect()->route('apps.daftar-ta')->with('success', 'Data berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function destroy(TugasAkhir $tugasAkhir)
    {
        
    }

}
