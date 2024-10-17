<?php

namespace App\Http\Controllers\Administrator\PembagianDosen;

use App\Models\Dosen;
use App\Models\PeriodeTa;
use App\Models\BimbingUji;
use App\Models\KuotaDosen;
use App\Models\TugasAkhir;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
class PembagianDosenController extends Controller
{
    public function index(Request $request)
    {
        $dosen = Dosen::where('id', getInfoLogin()->userable_id)->first();
        $prodi = $dosen->programStudi->nama;
        $periode = PeriodeTa::where('is_active', true)->first();
        $query = [];
        if($prodi) {
            $query =  TugasAkhir::with(['mahasiswa','bimbing_uji','periode_ta','topik','jenis_ta'])->whereHas('mahasiswa', function($query) use ($prodi) {
                $query->whereHas('programStudi', function($q) use ($prodi) {
                    $q->where('nama', $prodi);
                });
            })->where('status', 'acc')->where('periode_ta_id', $periode->id);

            if($request->has('is_completed')) {
                $query = $query->where('is_completed', $request->is_completed);
            } else {
                $query = $query->where('is_completed', 1);
            }

            $query = $query->get();
        }


        $data = [
            'title' => 'Pembagian Dosen',
            'mods' => 'pembagian_dosen',
            'breadcrumbs' => [
                [
                    'title' => 'Dashboard',
                    'url' => route('apps.dashboard')
                ],
                [
                    'title' => 'Tugas Akhir',
                    'is_active' => true,
                ],
                [
                    'title' => 'Pembagian Dosen',
                    'is_active' => true,
                ],
            ],
            'data' => $query,
        ];

        return view('administrator.pembagian-dosen.index', $data);
    }

    public function edit(TugasAkhir $tugasAkhir) 
    {
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
                
        $data = [
            'title' => 'Edit Pembagian Dosen',
            'mods' => 'pembagian_dosen',
            'breadcrumbs' => [
                [
                    'title' => 'Dashboard',
                    'url' => route('apps.dashboard')
                ],
                [
                    'title' => 'Tugas Akhir',
                    'is_active' => true,
                ],
                [
                    'title' => 'Pembagian Dosen',
                    'url' => route('apps.pembagian-dosen'),
                ],
                [
                    'title' => 'Edit Pembagian Dosen',
                    'is_active' => true,
                ],
            ],
            'action' => route('apps.pembagian-dosen.update', $tugasAkhir),
            'data' => $tugasAkhir,
            'pembimbing' => $pembimbing,
            'penguji' => $penguji,
            'dosen' => $dosen,
            'bimbingUji'   => BimbingUji::with(['tugas_akhir', 'dosen'])->where('jenis', 'pembimbing')->where('urut', 1)->where('tugas_akhir_id', $tugasAkhir->id)->first(),
            'bimbingUji2'   => BimbingUji::with(['tugas_akhir', 'dosen'])->where('jenis', 'pembimbing')->where('urut', 2)->where('tugas_akhir_id', $tugasAkhir->id)->first(),
            'bimbingUji3'   => BimbingUji::with(['tugas_akhir', 'dosen'])->where('jenis', 'penguji')->where('urut', 1)->where('tugas_akhir_id', $tugasAkhir->id)->first(),
            'bimbingUji4'   => BimbingUji::with(['tugas_akhir', 'dosen'])->where('jenis', 'penguji')->where('urut', 2)->where('tugas_akhir_id', $tugasAkhir->id)->first(),
        ];

        return view('administrator.pembagian-dosen.form', $data);
    }


    public function update(Request $request, TugasAkhir $tugasAkhir)
    {
        $request->validate([
            'pembimbing_2' => 'required',
            'penguji_1' => 'required',
            'penguji_2' => 'required',
        ],[
            'pembimbing_2.required' => 'Pembimbing 2 tidak boleh kosong',
            'penguji_1.required' => 'Penguji 1 tidak boleh kosong',
            'penguji_2.required' => 'Penguji 2 tidak boleh kosong',
        ]);

         try {
            DB::beginTransaction();
            $periode = PeriodeTa::where('is_active', 1)->first();
            $dat1 = $request->pemb_1;
            $dat2 = $request->pembimbing_2;
            $dat3 = $request->penguji_1;
            $dat4 = $request->penguji_2;
            $data = [$dat1, $dat2, $dat3, $dat4];
            if (count($data) !== count(array_unique($data))) {
                return redirect()->back()->with('error', 'Tidak boleh ada dosen yang sama!');
            }
            $pemb_2 = BimbingUji::with(['tugas_akhir', 'dosen'])->where('jenis', 'pembimbing')->where('urut', 2)->where('tugas_akhir_id', $tugasAkhir->id)->first();
            $kuota = KuotaDosen::where('dosen_id', $dat2)->where('periode_ta_id', $periode->id)->first();
            $bimbingUji2 = BimbingUji::with(['tugas_akhir', 'dosen'])->where('jenis', 'pembimbing')->where('urut', 2)->where('dosen_id', $dat2)->whereHas('tugas_akhir', function ($q) use($periode){
                $q->where('periode_ta_id', $periode->id);
            })->count();
            if(($pemb_2->dosen_id ?? null) != $dat2){
                if($bimbingUji2 >= $kuota->pembimbing_2){
                    return redirect()->back()->with('error', 'Kuota dosen pembimbing 2 yang di pilih telah mencapai batas');
                }
                if(isset($pemb_2->id)){
                    BimbingUji::with(['tugas_akhir', 'dosen'])->where('jenis', 'pembimbing')->where('urut', 2)->where('tugas_akhir_id', $tugasAkhir->id)->update([
                        'dosen_id' => $dat2,
                    ]);
                }else{
                    BimbingUji::create([
                        'jenis' => 'pembimbing',
                        'urut' => 2,
                        'tugas_akhir_id' => $tugasAkhir->id,
                        'dosen_id' => $dat2,
                    ]);
                }
            }

            $peng_1 = BimbingUji::with(['tugas_akhir', 'dosen'])->where('jenis', 'penguji')->where('urut', 1)->where('tugas_akhir_id', $tugasAkhir->id)->first();
            $kuota = KuotaDosen::where('dosen_id', $dat3)->where('periode_ta_id', $periode->id)->first();
            $bimbingUji3 = BimbingUji::with(['tugas_akhir', 'dosen'])->where('jenis', 'penguji')->where('urut', 1)->where('dosen_id', $dat3)->whereHas('tugas_akhir', function ($q) use($periode){
                $q->where('periode_ta_id', $periode->id);
            })->count();
            if(($peng_1->dosen_id ?? null) !== $dat3){
                if($bimbingUji3 >= $kuota->penguji_1){
                    return redirect()->back()->with('error', 'Kuota dosen Penguji 1 yang di pilih telah mencapai batas');
                }
                if(isset($peng_1->id)){
                    BimbingUji::with(['tugas_akhir', 'dosen'])->where('jenis', 'penguji')->where('urut', 1)->where('tugas_akhir_id', $tugasAkhir->id)->update([
                        'dosen_id' => $dat3,
                    ]);
                }else{
                    BimbingUji::create([
                        'jenis' => 'penguji',
                        'urut' => 1,
                        'tugas_akhir_id' => $tugasAkhir->id,
                        'dosen_id' => $dat3,
                    ]);
                }
            }

            $peng_2 = BimbingUji::with(['tugas_akhir', 'dosen'])->where('jenis', 'penguji')->where('urut', 2)->where('tugas_akhir_id', $tugasAkhir->id)->first();
            $kuota = KuotaDosen::where('dosen_id', $dat4)->where('periode_ta_id', $periode->id)->first();
            $bimbingUji4 = BimbingUji::with(['tugas_akhir', 'dosen'])->where('jenis', 'penguji')->where('urut', 2)->where('dosen_id', $dat4)->whereHas('tugas_akhir', function ($q) use($periode){
                $q->where('periode_ta_id', $periode->id);
            })->count();
            if(($peng_2->dosen_id ?? null) !== $dat4){
                if($bimbingUji4 >= $kuota->penguji_2){
                    return redirect()->back()->with('error', 'Kuota dosen Penguji 2 yang di pilih telah mencapai batas');
                }
                if(isset($peng_2->id)){
                    BimbingUji::with(['tugas_akhir', 'dosen'])->where('jenis', 'penguji')->where('urut', 2)->where('tugas_akhir_id', $tugasAkhir->id)->update([
                        'dosen_id' => $dat4,
                    ]);
                }else{
                    BimbingUji::create([
                        'jenis' => 'penguji',
                        'urut' => 2,
                        'tugas_akhir_id' => $tugasAkhir->id,
                        'dosen_id' => $dat4,
                    ]);
                }
            }
            $tugasAkhir->update(['is_completed' => true]);

            DB::commit();
            return redirect()->route('apps.pembagian-dosen')->with('success', 'Berhasil menyimpan data');
        } catch(\Exception $e){
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
