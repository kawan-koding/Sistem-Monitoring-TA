<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TugasAkhir;
use App\Models\PeriodeTa;
use App\Models\Ruangan;
use App\Models\Hari;
use App\Models\JadwalSeminar;
use App\Models\BimbingUji;
use App\Models\Mahasiswa;
use App\Models\Dosen;
use App\Mail\MyTestMail;
use Illuminate\Support\Facades\Mail;

class JadwalSeminarController extends Controller
{
    //
    public function index(Request $request)
    {
        $periode = PeriodeTa::where('is_active', 1)->first();
        $jadwal = JadwalSeminar::with(['tugas_akhir'])
            ->whereHas('tugas_akhir', function ($q) use ($periode) {
                $q->where('status', 'acc')->where('periode_ta_id', $periode->id);
            });

        if (isset($request->tanggal)) {
            $jadwal->whereDate('tanggal', $request->tanggal);
        }

        $hasilJadwal = $jadwal->get();


        $jadwalTS = JadwalSeminar::with(['tugas_akhir'])
            ->whereHas('tugas_akhir', function ($q) use ($periode) {
                $q->where('status', 'acc')->where('periode_ta_id', $periode->id);
            });
            $date = date('Y-m-d');
            $time = date('H:i:s');
            $jadwalTS = JadwalSeminar::with(['tugas_akhir'])
                ->whereHas('tugas_akhir', function ($q) use ($periode) {
                    $q->where('status', 'acc')->where('periode_ta_id', $periode->id);
                })
                ->where(function($query) use ($date, $time) {
                    $query->whereDate('tanggal', '>', now()->toDateString())
                        ->orWhere(function($subQuery) use ($date, $time) {
                            $subQuery->where('tanggal', '=', now()->toDateString())
                                    ->where('jam_selesai', '<', now()->toTimeString());
                        });
                });

            $hasilJadwalTS = $jadwalTS->get();
        $ta = TugasAkhir::where('periode_ta_id', $periode->id)->get();

        return view('jadwal-seminar.index', [
            "title" => "Jadwal Seminar",
            "breadcrumb1" => "Jadwal Seminar",
            "breadcrumb2" => "Index",
            'dataTA'   => $hasilJadwal,
            'dataTS'   => $hasilJadwalTS,
            'dataMyTa'   => $ta,
            'jsInit'      => 'js_jadwal_seminar.js',
        ]);
    }

    public function tambahJadwal($id)
    {
        $periode = PeriodeTa::where('is_active', 1)->first();
        $my_ta = TugasAkhir::with(['jenis_ta', 'topik'])->where('id', $id)->first();
        foreach ($my_ta->bimbing_uji as $bimuj) {
            if ($bimuj->jenis == 'pembimbing' && $bimuj->urut == 1){
                $item_pemb_1 = $bimuj->dosen->id;
                $name_pemb_1 = $bimuj->dosen->name;
            }
            if ($bimuj->jenis == 'pembimbing' && $bimuj->urut == 2){
                $item_pemb_2 = $bimuj->dosen->id;
                $name_pemb_2 = $bimuj->dosen->name;
            }
            if ($bimuj->jenis == 'penguji' && $bimuj->urut == 1){
                $item_peng_1 = $bimuj->dosen->id;
                $name_peng_1 = $bimuj->dosen->name;
            }
            if ($bimuj->jenis == 'penguji' && $bimuj->urut == 2){
                $item_peng_2 = $bimuj->dosen->id;
                $name_peng_2 = $bimuj->dosen->name;
            }
        }

        if(!isset($item_pemb_2) OR !isset($item_peng_1) OR !isset($item_peng_2)){
            return redirect()->back()->with('error', 'Data pembimbing dan penguji tidak boleh kosong!');
        }

        $jadwalSeminarTerdaftarPembimbing1 = [];
        $jadwalSeminarTerdaftarPembimbing2 = [];
        $jadwalSeminarTerdaftarPenguji1 = [];
        $jadwalSeminarTerdaftarPenguji2 = [];

        // Cek ta pembimbing 1
        $DataPembimbing1 = BimbingUji::with(['tugas_akhir', 'dosen'])->whereHas('dosen', function($q)use($item_pemb_1){
            $q->where('id', $item_pemb_1);
        })->whereHas('tugas_akhir', function($q)use($periode){
            $q->where('periode_ta_id', $periode->id);
        })->get();

        // cek jadwal pembimbing 1
        foreach ($DataPembimbing1 as $key) {
            $adadfa = JadwalSeminar::with(['tugas_akhir', 'ruangan'])->whereHas('tugas_akhir', function($q)use($periode, $key) {
                $q->where('periode_ta_id', $periode->id)->where('id', $key->tugas_akhir_id);
            })->first();
            // apakah data jadwal tersedia
            if(isset($adadfa)){
                $jadwalSeminarTerdaftarPembimbing1[] = [
                    'tanggal' => $adadfa->tanggal,
                    'jam_mulai' => $adadfa->jam_mulai,
                    'jam_selesai' => $adadfa->jam_selesai,
                ];
            }
        }

        // cek ta pembimbing 2
        $DataPembimbing2 = BimbingUji::with(['tugas_akhir', 'dosen'])->whereHas('dosen', function($q)use($item_pemb_2){
            $q->where('id', $item_pemb_2);
        })->whereHas('tugas_akhir', function($q)use($periode){
            $q->where('periode_ta_id', $periode->id);
        })->get();

        // cek jadwal pembimbing 2
        foreach ($DataPembimbing2 as $key) {
            $adadfa = JadwalSeminar::with(['tugas_akhir', 'ruangan'])->whereHas('tugas_akhir', function($q)use($periode, $key) {
                $q->where('periode_ta_id', $periode->id)->where('id', $key->tugas_akhir_id);
            })->first();
            // apakah data jadwal tersedia
            if(isset($adadfa)){
                $jadwalSeminarTerdaftarPembimbing2[] = [
                    'tanggal' => $adadfa->tanggal,
                    'jam_mulai' => $adadfa->jam_mulai,
                    'jam_selesai' => $adadfa->jam_selesai,
                ];
            }
        }

        // cek ta penguji 1
        $DataPenguji1 = BimbingUji::with(['tugas_akhir', 'dosen'])->whereHas('dosen', function($q)use($item_pemb_2){
            $q->where('id', $item_pemb_2);
        })->whereHas('tugas_akhir', function($q)use($periode){
            $q->where('periode_ta_id', $periode->id);
        })->get();

        // cek jadwal Penguji 1
        foreach ($DataPenguji1 as $key) {
            $adadfa = JadwalSeminar::with(['tugas_akhir', 'ruangan'])->whereHas('tugas_akhir', function($q)use($periode, $key) {
                $q->where('periode_ta_id', $periode->id)->where('id', $key->tugas_akhir_id);
            })->first();
            // apakah data jadwal tersedia
            if(isset($adadfa)){
                $jadwalSeminarTerdaftarPenguji1[] = [
                    'tanggal' => $adadfa->tanggal,
                    'jam_mulai' => $adadfa->jam_mulai,
                    'jam_selesai' => $adadfa->jam_selesai,
                ];
            }
        }

        // cek ta penguji 2
        $DataPenguji2 = BimbingUji::with(['tugas_akhir', 'dosen'])->whereHas('dosen', function($q)use($item_pemb_2){
            $q->where('id', $item_pemb_2);
        })->whereHas('tugas_akhir', function($q)use($periode){
            $q->where('periode_ta_id', $periode->id);
        })->get();

        // cek jadwal Penguji 2
        foreach ($DataPenguji2 as $key) {
            $adadfa = JadwalSeminar::with(['tugas_akhir', 'ruangan'])->whereHas('tugas_akhir', function($q)use($periode, $key) {
                $q->where('periode_ta_id', $periode->id)->where('id', $key->tugas_akhir_id);
            })->first();
            // apakah data jadwal tersedia
            if(isset($adadfa)){
                $jadwalSeminarTerdaftarPenguji2[] = [
                    'tanggal' => $adadfa->tanggal,
                    'jam_mulai' => $adadfa->jam_mulai,
                    'jam_selesai' => $adadfa->jam_selesai,
                ];
            }
        }

        // dd($jadwalSeminarTerdaftarPembimbing1);

        return view('jadwal-seminar.tambah-jadwal', [
            "title" => "Jadwal Seminar",
            "breadcrumb1" => "Jadwal Seminar",
            "breadcrumb2" => "Tambah Jadwal",
            'data'   => $my_ta,
            'ruangan' => Ruangan::all(),
            'hari' => Hari::all(),
            'pembimbing_1' => $name_pemb_1,
            'pembimbing_2' => $name_pemb_2,
            'penguji_1' => $name_peng_1,
            'penguji_2' => $name_peng_2,
            'jadwalSeminar' => JadwalSeminar::where('tugas_akhir_id', $id)->first(),
            'jadwalSeminarTerdaftarPembimbing1' => $jadwalSeminarTerdaftarPembimbing1,
            'jadwalSeminarTerdaftarPembimbing2' => $jadwalSeminarTerdaftarPembimbing2,
            'jadwalSeminarTerdaftarPenguji1' => $jadwalSeminarTerdaftarPenguji1,
            'jadwalSeminarTerdaftarPenguji2' => $jadwalSeminarTerdaftarPenguji2,
            'jsInit'      => 'js_jadwal_seminar.js',
        ]);
    }

    public function store($id, Request $request)
    {
        try{
            setlocale(LC_ALL, 'id_ID', 'Indonesian_indonesia');

            $existingJadwal = JadwalSeminar::with(['tugas_akhir'])->where('tanggal', $request->tanggal)
            ->where('tugas_akhir_id', '!=', $id)
            ->where('ruangan_id', $request->ruangan)
            ->where(function ($query) use ($request) {
                $query->where(function ($q) use ($request) {
                    $q->where('jam_mulai', '>=', $request->jam_mulai)
                        ->where('jam_mulai', '<', $request->jam_selesai);
                })->orWhere(function ($q) use ($request) {
                    $q->where('jam_mulai', '<', $request->jam_mulai)
                        ->where('jam_selesai', '>', $request->jam_mulai);
                });
            })
            ->first();

            if(isset($existingJadwal)){
                return redirect()->back()->with('error', 'Ruangan telah digunakan')->withInput($request->all());
            }

            $existingJadwal = JadwalSeminar::with(['tugas_akhir'])->where('tanggal', $request->tanggal)
            ->where('tugas_akhir_id', '!=', $id)
            ->where(function ($query) use ($request) {
                $query->where(function ($q) use ($request) {
                    $q->where('jam_mulai', '>=', $request->jam_mulai)
                        ->where('jam_mulai', '<', $request->jam_selesai);
                })->orWhere(function ($q) use ($request) {
                    $q->where('jam_mulai', '<', $request->jam_mulai)
                        ->where('jam_selesai', '>', $request->jam_mulai);
                });
            })
            ->first();
            
            if(isset($existingJadwal->id)){
                foreach ($existingJadwal->tugas_akhir->bimbing_uji as $key) {
                    $dosen_id = $key->dosen_id;
                    $pemb1 = BimbingUji::where('tugas_akhir_id', $id)->where('jenis', 'pembimbing')->where('urut', 1)->first();

                    if($pemb1->dosen_id == $dosen_id){
                        return redirect()->back()->with('error', 'Dosen Pembimbing 1 sudah memiliki jadwal')->withInput($request->all());
                    }

                    $pemb2 = BimbingUji::where('tugas_akhir_id', $id)->where('jenis', 'pembimbing')->where('urut', 2)->first();

                    if($pemb2->dosen_id == $dosen_id){
                        return redirect()->back()->with('error', 'Dosen Pembimbing 2 sudah memiliki jadwal')->withInput($request->all());
                    }

                    $peng1 = BimbingUji::where('tugas_akhir_id', $id)->where('jenis', 'penguji')->where('urut', 1)->first();

                    if($peng1->dosen_id == $dosen_id){
                        return redirect()->back()->with('error', 'Dosen Penguji 1 sudah memiliki jadwal')->withInput($request->all());
                    }

                    $peng2 = BimbingUji::where('tugas_akhir_id', $id)->where('jenis', 'penguji')->where('urut', 1)->first();
                    if($peng2->dosen_id == $dosen_id){
                        return redirect()->back()->with('error', 'Dosen Penguji 2 sudah memiliki jadwal')->withInput($request->all());
                    }
                }
            }
            $pemb1 = BimbingUji::where('tugas_akhir_id', $id)->where('jenis', 'pembimbing')->where('urut', 1)->first();
            $pemb2 = BimbingUji::where('tugas_akhir_id', $id)->where('jenis', 'pembimbing')->where('urut', 2)->first();
            $peng1 = BimbingUji::where('tugas_akhir_id', $id)->where('jenis', 'penguji')->where('urut', 1)->first();
            $peng2 = BimbingUji::where('tugas_akhir_id', $id)->where('jenis', 'penguji')->where('urut', 2)->first();
            // dd($pemb1->dosen_id);

            $jadwal = JadwalSeminar::where('tugas_akhir_id', $id)->first();

            // Mengonversi tanggal ke timestamp
            $timestamp = strtotime($request->tanggal);

            
            // Mendapatkan nama hari dalam bahasa Indonesia
            $hari = strftime('%A', $timestamp);
            $day = Hari::where('nama_hari', $hari)->first();
            // dd($day);
            $ta = TugasAkhir::find($id);
            $mhsSend = Mahasiswa::find($ta->mahasiswa_id);
            $pemb1Send = Dosen::find($pemb1->dosen_id);
            $pemb2Send = Dosen::find($pemb2->dosen_id);
            $peng1Send = Dosen::find($peng1->dosen_id);
            $peng2Send = Dosen::find($peng2->dosen_id);

            $emailSendAkun = (object)[
                [
                    'email' => $mhsSend->email,
                    'name' => $mhsSend->nama_mhs,
                    'sebagai' => 'Mahasiswa',
                ],
                [
                    'email' => $pemb1Send->email,
                    'name' => $pemb1Send->name,
                    'sebagai' => 'Pembimbing 1',
                ],
                [
                    'email' => $pemb2Send->email,
                    'name' => $pemb2Send->name,
                    'sebagai' => 'Pembimbing 2',
                ],
                [
                    'email' => $peng1Send->email,
                    'name' => $peng1Send->name,
                    'sebagai' => 'Penguji 1',
                ],
                [
                    'email' => $peng2Send->email,
                    'name' => $peng2Send->name,
                    'sebagai' => 'Penguji 2',
                ],
            ];
            
            foreach ($emailSendAkun as $k) {
                # code...
                // dd($k['name']);
                $to = [
                    'name' => $k['name'],
                    'sebagai' => $k['sebagai'],
                ];
                $seminar = [
                    'tanggal' => $request->tanggal,
                    'jam_mulai' => $request->jam_mulai,
                    'jam_selesai' => $request->jam_selesai,
                ];
                $this->sendEmail($to, $seminar, $ta, $k['email']);
            }
            // dd(1);
            if(!isset($jadwal->id)){
                JadwalSeminar::create([
                    'tugas_akhir_id' => $id,
                    'ruangan_id' => $request->ruangan,
                    'hari_id' => $day->id,
                    'jam_mulai' => $request->jam_mulai,
                    'jam_selesai' => $request->jam_selesai,
                    'tanggal' => $request->tanggal,
                    'status' => 1,
                ]);
            }else{
                JadwalSeminar::where('tugas_akhir_id', $id)->update([
                    'ruangan_id' => $request->ruangan,
                    'hari_id' => $day->id,
                    'jam_mulai' => $request->jam_mulai,
                    'jam_selesai' => $request->jam_selesai,
                    'tanggal' => $request->tanggal,
                ]);
            }

            return redirect()->route('admin.jadwal-seminar')->with('success', 'Berhasil menambah jadwal seminar');
        }catch(\Exception $e){
            return redirect()->back()->with('error', $e->getMessage())->withInput($request->all());
        }
    }

    public function chekRuangan(Request $request)
    {
        setlocale(LC_ALL, 'id_ID', 'Indonesian_indonesia');

            $existingJadwal = JadwalSeminar::with(['tugas_akhir'])->where('tanggal', $request->tanggal)
            // ->where('tugas_akhir_id', '!=', $id)
            ->where('ruangan_id', $request->ruangan)
            ->where(function ($query) use ($request) {
                $query->where(function ($q) use ($request) {
                    $q->where('jam_mulai', '>=', $request->jam_mulai)
                        ->where('jam_mulai', '<', $request->jam_selesai);
                })->orWhere(function ($q) use ($request) {
                    $q->where('jam_mulai', '<', $request->jam_mulai)
                        ->where('jam_selesai', '>', $request->jam_mulai);
                });
            })
            ->first();

            if(isset($existingJadwal->id)){
                echo json_encode(1);
            }else{
                echo json_encode(0);
            }
    }

    public function sendEmail($to, $seminar, $ta, $penerima){
        $details = [
            'to' => $to,
            'seminar' => $seminar,
            'ta' => $ta,
            ];
           
            \Mail::to($penerima)->send(new \App\Mail\sendMail($details));
    }
}
