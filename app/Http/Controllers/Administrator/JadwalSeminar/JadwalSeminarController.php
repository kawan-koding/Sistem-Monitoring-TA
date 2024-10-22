<?php

namespace App\Http\Controllers\Administrator\JadwalSeminar;

use App\Http\Controllers\Controller;
use App\Models\JadwalSeminar;
use App\Models\Mahasiswa;
use App\Models\PeriodeTa;
use App\Models\Ruangan;
use Illuminate\Http\Request;

class JadwalSeminarController extends Controller
{
    public function index(Request $request)
    {
        $query = [];
        $periode = PeriodeTa::where('is_active', 1)->first();
        if(getInfoLogin()->hasRole('Admin')) {
            $query = JadwalSeminar::whereHas('tugas_akhir', function ($q) use($periode) { 
                $q->where('status', 'acc')->where('periode_ta_id', $periode->id); 
            });

            if($request->has('tanggal') && !empty($request->tanggal)) {
                $query = $query->whereDate('tanggal', $request->tanggal);
            }

            if($request->has('status') && !empty($request->status)) {
                $query = $query->where('status', $request->status);
            } else {
                $query = $query->where('status', 'belum_terjadwal');
            }
            $query = $query->get();

            // dd($query);
        }
        if(getInfoLogin()->hasRole('Mahasiswa')) {
            $myId = getInfoLogin()->userable;
            $mahasiswa = Mahasiswa::where('id', $myId->id)->first();
            // dd($myId);
            if($mahasiswa) {
                $query = JadwalSeminar::whereHas('tugas_akhir', function ($q) use($periode, $mahasiswa) {
                    $q->where('periode_ta_id', $periode->id)->where('mahasiswa_id', $mahasiswa->id);
                })->get();
                // dd($query);
            }
        }

        $data = [
            'title' =>  'Jadwal Seminar',
            'breadcrumbs' =>[
                [
                    'title' => 'Dashboard',
                    'url' => route('apps.dashboard')
                ],
                [
                    'title' => 'Tugas Akhir',
                    'is_active' => true,
                ],
                [
                    'title' => 'Jadwal Seminar',
                    'is_active' => true,
                ]
                ],
            'data' => $query,
        ];

        return view('administrator.jadwal-seminar.index', $data);
    }


    public function edit(JadwalSeminar $jadwalSeminar)
    {
        $data = [
            'title' => 'Jadwal Seminar',
            'breadcrumbs' =>[
                [
                    'title' => 'Dashboard',
                    'url' => route('apps.dashboard'),
                ],
                [
                    'title' => 'Tugas Akhir',
                    'is_active' => true,
                ],
                [
                    'title' => 'Jadwal Seminar',
                    'is_active' => true,
                ]
            ],
            'jadwalSeminar' => $jadwalSeminar,
            'ruangan' => Ruangan::all(),
            'editedData' => $jadwalSeminar,
            'jadwalPembimbing1' => JadwalSeminar::whereHas('tugas_akhir', function ($query) use ($jadwalSeminar) {
                $query->whereHas('bimbing_uji', function ($query) use ($jadwalSeminar) {
                    $dosenId = $jadwalSeminar->tugas_akhir->bimbing_uji()->where('jenis', 'pembimbing')->where('urut', 1)->first();
                    $dosenId = is_null($dosenId) ? null : $dosenId->dosen_id;

                    if(is_null($dosenId)) {
                        $query->whereNull('dosen_id');
                    } else {
                        $query->where('dosen_id', $dosenId);
                    }
                    $query->where('jenis', 'pembimbing')->where('urut', 1);
                });
            })->where('status', 'sudah_terjadwal')->get(),
            'jadwalPembimbing2' => JadwalSeminar::whereHas('tugas_akhir', function ($query) use ($jadwalSeminar) {
                $query->whereHas('bimbing_uji', function ($query) use ($jadwalSeminar) {
                    $dosenId = $jadwalSeminar->tugas_akhir->bimbing_uji()->where('jenis', 'pembimbing')->where('urut', 2)->first();
                    $dosenId = is_null($dosenId) ? null : $dosenId->dosen_id;

                    if(is_null($dosenId)) {
                        $query->whereNull('dosen_id');
                    } else {
                        $query->where('dosen_id', $dosenId);
                    }
                    $query->where('jenis', 'pembimbing')->where('urut', 2);
                });
            })->where('status', 'sudah_terjadwal')->get(),
            'jadwalPenguji1' => JadwalSeminar::whereHas('tugas_akhir', function ($query) use ($jadwalSeminar) {
                $query->whereHas('bimbing_uji', function ($query) use ($jadwalSeminar) {
                    $dosenId = $jadwalSeminar->tugas_akhir->bimbing_uji()->where('jenis', 'penguji')->where('urut', 1)->first();
                    $dosenId = is_null($dosenId) ? null : $dosenId->dosen_id;

                    if(is_null($dosenId)) {
                        $query->whereNull('dosen_id');
                    } else {
                        $query->where('dosen_id', $dosenId);
                    }
                    $query->where('jenis', 'penguji')->where('urut', 1);
                });
            })->where('status', 'sudah_terjadwal')->get(),
            'jadwalPenguji2' => JadwalSeminar::whereHas('tugas_akhir', function ($query) use ($jadwalSeminar) {
                $query->whereHas('bimbing_uji', function ($query) use ($jadwalSeminar) {
                    $dosenId = $jadwalSeminar->tugas_akhir->bimbing_uji()->where('jenis', 'penguji')->where('urut', 2)->first();
                    $dosenId = is_null($dosenId) ? null : $dosenId->dosen_id;

                    if(is_null($dosenId)) {
                        $query->whereNull('dosen_id');
                    } else {
                        $query->where('dosen_id', $dosenId);
                    }
                    $query->where('jenis', 'penguji')->where('urut', 2);
                });
            })->where('status', 'sudah_terjadwal')->get(),
            
        ];

        // dd($data);
        return view('administrator.jadwal-seminar.form', $data);
    }

    public function update(Request $request, JadwalSeminar $jadwalSeminar) 
    {
        $request->validate([
            'ruangan' => 'required',
            'tanggal' => 'required',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
        ],
        [
            'ruangan.required' => 'Ruangan harus diisi',
            'tanggal.required' => 'Tanggal harus diisi',
            'jam_mulai.required' => 'Jam mulai harus diisi',
            'jam_selesai.required' => 'Jam selesai harus diisi',
        ]);
        try {
            $check = JadwalSeminar::whereRuanganId($request->ruangan)->whereDate('tanggal', $request->tanggal)->where('jam_mulai', '>=', $request->jam_mulai)->where('jam_selesai', '<=', $request->jam_selesai)->first();

            if(!is_null($check)) {
                return redirect()->back()->with(['error' => 'Jadwal ini sudah ada']);
            }

            $jadwalSeminar->update([
                'ruangan_id' => $request->ruangan,
                'tanggal' => $request->tanggal,
                'jam_mulai' => $request->jam_mulai,
                'jam_selesai' => $request->jam_selesai,
                'status' => 'sudah_terjadwal'
            ]);
            return redirect()->route('apps.jadwal-seminar')->with(['success' => 'Jadwal seminar telah diubah']);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    // public function uploadFile(Request $request)
    // {

    // }
}
