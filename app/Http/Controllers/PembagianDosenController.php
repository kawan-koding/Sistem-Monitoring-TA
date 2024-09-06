<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TugasAkhir;
use App\Models\BimbingUji;
use App\Models\KuotaDosen;
use App\Models\PeriodeTa;
use App\Models\Dosen;

class PembagianDosenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view('kaprodi-menu.pembagiandosen.index', [
            "title" => "Pembagian Dosen",
            "breadcrumb1" => "Pembagian Dosen",
            "breadcrumb2" => "Index",
            'dataTA'   => TugasAkhir::with(['jenis_ta', 'topik'])->where('status', 'acc')->get(),
            'jsInit'      => 'js_pembagian_dosen.js',
        ]);
    }

    public function edit(string $id)
    {
        //
        $periode = PeriodeTa::where('is_active', 1)->first();
        $dataDosen = Dosen::all();
        $dosen = [];
        foreach ($dataDosen as $key) {
            # code...
            $kuota = KuotaDosen::where('dosen_id', $key->id)->where('periode_ta_id', $periode->id)->first();
            $bimbingUji = BimbingUji::with(['tugas_akhir', 'dosen'])->where('dosen_id', $key->id)->where('jenis', 'pembimbing')->where('urut', 1)->whereHas('tugas_akhir', function ($q) use($periode){
                $q->where('periode_ta_id', $periode->id);
            })->count();
            $bimbingUji2 = BimbingUji::with(['tugas_akhir', 'dosen'])->where('dosen_id', $key->id)->where('jenis', 'pembimbing')->where('urut', 2)->whereHas('tugas_akhir', function ($q) use($periode){
                $q->where('periode_ta_id', $periode->id);
            })->count();
            $bimbingUji3 = BimbingUji::with(['tugas_akhir', 'dosen'])->where('dosen_id', $key->id)->where('jenis', 'penguji')->where('urut', 1)->whereHas('tugas_akhir', function ($q) use($periode){
                $q->where('periode_ta_id', $periode->id);
            })->count();
            $bimbingUji4 = BimbingUji::with(['tugas_akhir', 'dosen'])->where('dosen_id', $key->id)->where('jenis', 'penguji')->where('urut', 2)->whereHas('tugas_akhir', function ($q) use($periode){
                $q->where('periode_ta_id', $periode->id);
            })->count();
            // dd(10);
            $dosen[] = (object)[
                'id' => $key->id,
                'nidn' => $key->nidn,
                'nama' => $key->name,
                'name' => $key->name,
                'kuota_pemb_1' => ($kuota->pemb_1 ?? 0),
                'kuota_pemb_2' => ($kuota->pemb_2 ?? 0),
                'kuota_peng_1' => ($kuota->penguji_1 ?? 0),
                'kuota_peng_2' => ($kuota->penguji_2 ?? 0),
                'total_pemb_1' => $bimbingUji,
                'total_pemb_2' => $bimbingUji2,
                'total_peng_1' => $bimbingUji3,
                'total_peng_2' => $bimbingUji4,
            ];
        }
        return view('kaprodi-menu.pembagiandosen.form-edit', [
            "title" => "Pembagian Dosen",
            "breadcrumb1" => "Pembagian Dosen",
            "breadcrumb2" => "Edit",
            'data'        => TugasAkhir::find($id),
            'dataDosen'   => $dosen,
            'dosenKuota'   => $dosen,
            'bimbingUji'   => BimbingUji::with(['tugas_akhir', 'dosen'])->where('jenis', 'pembimbing')->where('urut', 1)->where('tugas_akhir_id', $id)->first(),
            'bimbingUji2'   => BimbingUji::with(['tugas_akhir', 'dosen'])->where('jenis', 'pembimbing')->where('urut', 2)->where('tugas_akhir_id', $id)->first(),
            'bimbingUji3'   => BimbingUji::with(['tugas_akhir', 'dosen'])->where('jenis', 'penguji')->where('urut', 1)->where('tugas_akhir_id', $id)->first(),
            'bimbingUji4'   => BimbingUji::with(['tugas_akhir', 'dosen'])->where('jenis', 'penguji')->where('urut', 2)->where('tugas_akhir_id', $id)->first(),
            'jsInit'      => 'js_pembagian_dosen.js',
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        try{
            $periode = PeriodeTa::where('is_active', 1)->first();

            $dat1 = $request->pemb_1;
            $dat2 = $request->pemb_2;
            $dat3 = $request->peng_1;
            $dat4 = $request->peng_2;

            $data = [$dat1, $dat2, $dat3, $dat4];

            // dd($data);

            // cek duplikat
            if (count($data) !== count(array_unique($data))) {
                return redirect()->back()->with('error', 'Tidak boleh ada dosen yang sama!');
            }

            //pembimbing 2
            $pemb_2 = BimbingUji::with(['tugas_akhir', 'dosen'])->where('jenis', 'pembimbing')->where('urut', 2)->where('tugas_akhir_id', $id)->first();

            $kuota = KuotaDosen::where('dosen_id', $request->pemb_2)->where('periode_ta_id', $periode->id)->first();
            $bimbingUji2 = BimbingUji::with(['tugas_akhir', 'dosen'])->where('jenis', 'pembimbing')->where('urut', 2)->where('dosen_id', $request->pemb_2)->whereHas('tugas_akhir', function ($q) use($periode){
                $q->where('periode_ta_id', $periode->id);
            })->count();

            if(($pemb_2->dosen_id ?? null) != $request->pemb_2){

                if($bimbingUji2 >= $kuota->pemb_2){

                    return redirect()->back()->with('error', 'Kuota dosen pembimbing 2 yang di pilih telah mencapai batas');

                }

                if(isset($pemb_2->id)){

                    BimbingUji::with(['tugas_akhir', 'dosen'])->where('jenis', 'pembimbing')->where('urut', 2)->where('tugas_akhir_id', $id)->update([
                        'dosen_id' => $request->pemb_2,
                    ]);

                }else{
                    BimbingUji::create([
                        'jenis' => 'pembimbing',
                        'urut' => 2,
                        'tugas_akhir_id' => $id,
                        'dosen_id' => $request->pemb_2,
                    ]);
                }
            }


            //penguji 1
            $peng_1 = BimbingUji::with(['tugas_akhir', 'dosen'])->where('jenis', 'penguji')->where('urut', 1)->where('tugas_akhir_id', $id)->first();

            $kuota = KuotaDosen::where('dosen_id', $request->peng_1)->where('periode_ta_id', $periode->id)->first();
            $bimbingUji3 = BimbingUji::with(['tugas_akhir', 'dosen'])->where('jenis', 'penguji')->where('urut', 1)->where('dosen_id', $request->peng_1)->whereHas('tugas_akhir', function ($q) use($periode){
                $q->where('periode_ta_id', $periode->id);
            })->count();

            if(($peng_1->dosen_id ?? null) !== $request->peng_1){
                if($bimbingUji3 >= $kuota->penguji_1){

                    return redirect()->back()->with('error', 'Kuota dosen Penguji 1 yang di pilih telah mencapai batas');

                }

                if(isset($peng_1->id)){

                    BimbingUji::with(['tugas_akhir', 'dosen'])->where('jenis', 'penguji')->where('urut', 1)->where('tugas_akhir_id', $id)->update([
                        'dosen_id' => $request->peng_1,
                    ]);

                }else{
                    BimbingUji::create([
                        'jenis' => 'penguji',
                        'urut' => 1,
                        'tugas_akhir_id' => $id,
                        'dosen_id' => $request->peng_1,
                    ]);
                }
            }

            //penguji 2
            $peng_2 = BimbingUji::with(['tugas_akhir', 'dosen'])->where('jenis', 'penguji')->where('urut', 2)->where('tugas_akhir_id', $id)->first();

            $kuota = KuotaDosen::where('dosen_id', $request->peng_2)->where('periode_ta_id', $periode->id)->first();
            $bimbingUji4 = BimbingUji::with(['tugas_akhir', 'dosen'])->where('jenis', 'penguji')->where('urut', 2)->where('dosen_id', $request->peng_2)->whereHas('tugas_akhir', function ($q) use($periode){
                $q->where('periode_ta_id', $periode->id);
            })->count();

            if(($peng_2->dosen_id ?? null) !== $request->peng_2){
                if($bimbingUji4 >= $kuota->penguji_2){

                    return redirect()->back()->with('error', 'Kuota dosen Penguji 2 yang di pilih telah mencapai batas');

                }

                if(isset($peng_2->id)){

                    BimbingUji::with(['tugas_akhir', 'dosen'])->where('jenis', 'penguji')->where('urut', 2)->where('tugas_akhir_id', $id)->update([
                        'dosen_id' => $request->peng_2,
                    ]);

                }else{
                    BimbingUji::create([
                        'jenis' => 'penguji',
                        'urut' => 2,
                        'tugas_akhir_id' => $id,
                        'dosen_id' => $request->peng_2,
                    ]);
                }
            }



            return redirect()->route('kaprodi.pembagian-dosen')->with('success', 'Pembagian dosen telah berhasil');
        }catch(\Exception $e){
            return redirect()->route('kaprodi.pembagian-dosen')->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
