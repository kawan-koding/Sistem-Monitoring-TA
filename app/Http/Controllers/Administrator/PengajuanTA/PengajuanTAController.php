<?php

namespace App\Http\Controllers\Administrator\PengajuanTA;

use Carbon\Carbon;
use App\Models\Dosen;
use App\Models\Topik;
use App\Models\Sidang;
use App\Models\JenisTa;
use App\Models\Mahasiswa;
use App\Models\PeriodeTa;
use App\Models\BimbingUji;
use App\Models\KuotaDosen;
use App\Models\TugasAkhir;
use App\Models\Pemberkasan;
use App\Models\JenisDokumen;
use Illuminate\Http\Request;
use App\Models\JadwalSeminar;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\Http\Requests\PengajuanTA\PengajuanTARequest;

class PengajuanTAController extends Controller
{
    public function index(Request $request)
    {
        $query = [];
        if (getInfoLogin()->hasRole('Mahasiswa')) {
            $myId = getInfoLogin()->username;
            $mahasiswa = Mahasiswa::where('nim', $myId)->first();
            if ($mahasiswa) {
                $query = TugasAkhir::with(['jenis_ta', 'topik'])->where('mahasiswa_id', $mahasiswa->id)->get();
            }
        }
        if (getInfoLogin()->hasRole('Kaprodi')) {
            $login = Dosen::where('id', getInfoLogin()->userable_id)->first();
            $prodi = $login->programStudi->nama;
            $query = TugasAkhir::with(['jenis_ta', 'topik'])->whereHas('mahasiswa', function ($query) use ($prodi) {
                $query->whereHas('programStudi', function ($q) use ($prodi) {
                    $q->where('nama', $prodi);
                });
            });

            if ($request->has('filter') && !empty($request->filter) && $request->filter != 'semua') {
                $query = $query->where('tipe', $request->filter);
            }

            if ($request->has('status') && !empty($request->status)) {
                $query = $query->whereIn('status', [$request->status, 'cancel']);
            } else {
                $query = $query->whereIn('status', ['draft', 'pengajuan ulang']);
            }

            $query = $query->get();
        }

        $data = [
            'title' => 'Pengajuan Tugas Akhir',
            'mods' => 'pengajuan_ta',
            'breadcrumbs' => [
                [
                    'title' => 'Dashboard',
                    'url' => route('apps.dashboard')
                ],
                [
                    'title' => getInfoLogin()->hasRole('Mahasiswa') ? 'Tugas Akhir' : 'Pengajuan Tugas Akhir',
                    'is_active' => true
                ]
            ],
            'dataTA'   => $query,
            'filter' => $request->has('filter') ? $request->filter : 'semua',
            'status' => $request->has('status') ? $request->status : 'draft',
        ];

        return view('administrator.pengajuan-ta.index', $data);
    }

    public function create()
    {
        $user = getInfoLogin()->userable;
        $prodi = $user->programStudi;
        $periode = PeriodeTa::where('is_active', 1)->where('program_studi_id', $prodi->id)->first();
        $dataDosen = Dosen::all();
        $dosen = [];
        foreach ($dataDosen as $key) {
            $kuota = KuotaDosen::where('dosen_id', $key->id)->where('periode_ta_id', $periode->id)->where('program_studi_id', $prodi->id)->first();
            $bimbingUji = BimbingUji::with(['tugas_akhir', 'dosen'])->where('dosen_id', $key->id)->where('jenis', 'pembimbing')->where('urut', 1)->whereHas('tugas_akhir', function ($q) use ($periode) {
                $q->where('periode_ta_id', $periode->id)->whereNotIn('status', ['reject', 'cancel']);
            })->count();
            $dosen[] = (object)[
                'id' => $key->id,
                'nidn' => $key->nidn,
                'nama' => $key->name,
                'name' => $key->name,
                'kuota_pembimbing_1' => ($kuota->pembimbing_1 ?? 0),
                'total_pembimbing_1' => $bimbingUji,
            ];
        }

        $docPengajuan = JenisDokumen::where('jenis', 'pendaftaran')->get();
        $data = [
            'title' => 'Pengajuan Tugas Akhir',
            'dataJenis'   => JenisTa::all(),
            'dataTopik'   => Topik::all(),
            'dataDosen'   => $dosen,
            'doc' => $docPengajuan,
            'dosenKuota'   => $dosen,
            'mods' => 'pengajuan_ta',
            'breadcrumbs' => [
                [
                    'title' => 'Dashboard',
                    'url' => route('apps.dashboard')
                ],
                [
                    'title' => getInfoLogin()->hasRole('Mahasiswa') ? 'Tugas Akhir' : 'Pengajuan Tugas Akhir',
                    'url' => route('apps.pengajuan-ta'),
                ],
                [
                    'title' => 'Tambah Pengajuan Tugas Akhir',
                    'is_active' => true
                ]
            ],
        ];

        return view('administrator.pengajuan-ta.partials.form', $data);
    }

    public function store(PengajuanTARequest $request)
    {
        try {
            DB::beginTransaction();
            $user = getInfoLogin()->userable;
            $prodi = $user->programStudi;
            $periode = PeriodeTa::where('is_active', 1)->where('program_studi_id', $prodi->id)->first();
            if (!is_null($periode) && !Carbon::parse($periode->akhir_daftar)->addDays(1)->isFuture()) {
                return redirect()->back()->with('error', 'Pengajuan Tugas Akhir melebihi batas periode');
            }
            if (!is_null($periode) && Carbon::parse($periode->mulai_daftar)->addDays(1)->isFuture()) {
                return redirect()->back()->with('error', 'Periode pengajuan Tugas Akhir belum aktif');
            }
            $myId = Auth::user()->username;
            $mahasiswa = Mahasiswa::where('nim', $myId)->first();

            $kuota = KuotaDosen::where('dosen_id', $request->pembimbing_1)->where('periode_ta_id', $periode->id)->first();
            $bimbingUji = BimbingUji::with(['tugas_akhir', 'dosen'])->where('jenis', 'pembimbing')->where('urut', 1)->where('dosen_id', $request->pembimbing_1)->whereHas('tugas_akhir', function ($q) use ($periode) {
                $q->where('periode_ta_id', $periode->id)->whereNotIn('status', ['reject', 'cancel']);
            })->count();
            if ($bimbingUji >= (!is_null($kuota) ? $kuota->pembimbing_1 : 0)) {
                return redirect()->back()->with('error', 'Kuota dosen pembimbing 1 yang di pilih telah mencapai batas');
            }

            if ($request->jenis_ta_new !== null) {
                $newJenis = JenisTa::create(['nama_jenis' => $request->jenis_ta_new]);
                $jenis = $newJenis->id;
            } else {
                $jenis = $request->jenis_ta_id;
            }

            if ($request->topik_ta_new !== null) {
                $newTopik = Topik::create(['nama_topik' => $request->topik_ta_new]);
                $topik = $newTopik->id;
            } else {
                $topik = $request->topik;
            }

            $result = TugasAkhir::create([
                'jenis_ta_id' => $jenis,
                'topik_id' => $topik,
                'mahasiswa_id' => $mahasiswa->id,
                'periode_ta_id' => $periode->id,
                'judul' => $request->judul,
                'tipe' => $request->tipe,
                'status' => 'draft',
            ]);

            BimbingUji::create([
                'tugas_akhir_id' => $result->id,
                'dosen_id' => $request->pembimbing_1,
                'jenis' => 'pembimbing',
                'urut' => 1,
            ]);

            $docPengajuan = JenisDokumen::where('jenis', 'pendaftaran')->get();
            $validates = [];
            $messages = [];
            $inserts = [];

            foreach ($docPengajuan as $item) {
                $validates['document_' . $item->id] = $item->tipe_dokumen == 'pdf' ? '|mimes:pdf|max:' . $item->max_ukuran : 'mimes:png,jpg,jpeg,webp|max:' . $item->max_ukuran;
                $messages['document_' . $item->id . '.mimes'] = 'Dokumen ' . strtolower($item->nama) . ' harus dalam format ' . ($item->tipe_dokumen == 'pdf' ? 'PDF' : 'PNG, JPEG, JPG, WEBP');
                $messages['document_' . $item->id . '.max'] = 'Dokumen ' . strtolower($item->nama) . ' tidak boleh lebih dari ' . $item->max_ukuran . ' KB';
            }

            $request->validate($validates, $messages);

            foreach ($docPengajuan as $item) {
                $file = $request->file('dokumen_' . $item->id);
                $filename = 'document_' . rand(0, 999999999) . '_' . rand(0, 999999999) . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('storage/files/pemberkasan'), $filename);

                $inserts[] = [
                    'tugas_akhir_id' => $result->id,
                    'jenis_dokumen_id' => $item->id,
                    'filename' => $filename,
                    'updated_at' => now(),
                    'created_at' => now()
                ];
            }

            Pemberkasan::insert($inserts);

            DB::commit();
            return redirect()->route('apps.pengajuan-ta')->with('success', 'Data berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function edit(TugasAkhir $pengajuanTA)
    {
        $user = getInfoLogin()->userable;
        $prodi = $user->programStudi;
        $periode = PeriodeTa::where('is_active', 1)->where('program_studi_id', $prodi->id)->first();
        $dataDosen = Dosen::all();
        $dosen = [];
        foreach ($dataDosen as $key) {
            # code...
            $kuota = KuotaDosen::where('dosen_id', $key->id)->where('periode_ta_id', $periode->id)->first();
            $bimbingUji = BimbingUji::with(['tugas_akhir', 'dosen'])->where('dosen_id', $key->id)->where('jenis', 'pembimbing')->where('urut', 1)->whereHas('tugas_akhir', function ($q) use ($periode) {
                $q->where('periode_ta_id', $periode->id)->whereNotIn('status', ['reject', 'cancel']);
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
        $docPengajuan = JenisDokumen::where('jenis', 'pendaftaran')->get();

        $data = [
            'title' => 'Pengajuan Tugas Akhir',
            'dataJenis'   => JenisTa::all(),
            'dataTopik'   => Topik::all(),
            'dataDosen'   => $dosen,
            'dosenKuota'   => $dosen,
            'mods' => 'pengajuan_ta',
            'editedData' => $pengajuanTA,
            'doc' => $docPengajuan,
            'breadcrumbs' => [
                [
                    'title' => 'Dashboard',
                    'url' => route('apps.dashboard')
                ],
                [
                    'title' => getInfoLogin()->hasRole('Mahasiswa') ? 'Tugas Akhir' : 'Pengajuan Tugas Akhir',
                    'url' => route('apps.pengajuan-ta'),
                ],
                [
                    'title' => 'Edit Pengajuan Tugas Akhir',
                    'is_active' => true
                ]
            ],
        ];

        // dd(JenisTa::all());

        return view('administrator.pengajuan-ta.partials.form', $data);
    }

    public function update(PengajuanTARequest $request, TugasAkhir $pengajuanTA)
    {
        try {
            DB::beginTransaction();

            if ($pengajuanTA->status == 'revisi') {
                $status = 'pengajuan ulang';
            } else {
                $status = $pengajuanTA->status;
            }

            if ($request->jenis_ta_new !== null) {
                $newJenis = JenisTa::create(['nama_jenis' => $request->jenis_ta_new]);
                $jenis = $newJenis->id;
            } else {
                $jenis = $request->jenis_ta_id;
            }

            if ($request->topik_ta_new !== null) {
                $newTopik = Topik::create(['nama_topik' => $request->topik_ta_new]);
                $topik = $newTopik->id;
            } else {
                $topik = $request->topik;
            }

            if ($pengajuanTA->status == 'acc') {
                $catatan = null;
            } else {
                $catatan = $pengajuanTA->catatan;
            }

            $pengajuanTA->update([
                'jenis_ta_id' => $jenis,
                'topik_id' => $topik,
                'judul' => $request->judul,
                'tipe' => $request->tipe,
                'status' => $status,
                'catatan' => $catatan
            ]);

            $docPengajuan = JenisDokumen::where('jenis', 'pendaftaran')->get();
            $validates = [];
            $messages = [];

            foreach ($docPengajuan as $item) {
                $validates['document_' . $item->id] = $item->tipe_dokumen == 'pdf' ? '|mimes:pdf|max:' . $item->max_ukuran : 'mimes:png,jpg,jpeg,webp|max:' . $item->max_ukuran;
                $messages['document_' . $item->id . '.mimes'] = 'Dokumen ' . strtolower($item->nama) . ' harus dalam format ' . ($item->tipe_dokumen == 'pdf' ? 'PDF' : 'PNG, JPEG, JPG, WEBP');
                $messages['document_' . $item->id . '.max'] = 'Dokumen ' . strtolower($item->nama) . ' tidak boleh lebih dari ' . $item->max_ukuran . ' KB';
            }

            $request->validate($validates, $messages);

            foreach ($docPengajuan as $item) {;
                if ($request->hasFile('dokumen_' . $item->id)) {
                    $file = $request->file('dokumen_' . $item->id);
                    $filename = 'document_' . rand(0, 999999999) . '_' . rand(0, 999999999) . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('storage/files/pemberkasan'), $filename);
                    $pemberkasan = Pemberkasan::where('tugas_akhir_id', $pengajuanTA->id)->where('jenis_dokumen_id', $item->id)->first();
                    if (!is_null($pemberkasan)) {
                        File::delete(public_path('Storage/files/pemberkasan/' . $pemberkasan->filename));
                        $pemberkasan->update([
                            'filename' => $filename,
                        ]);
                    } else {
                        Pemberkasan::create([
                            'tugas_akhir_id' => $pengajuanTA->id,
                            'jenis_dokumen_id' => $item->id,
                            'filename' => $filename,
                        ]);
                    }
                }
            }

            DB::commit();
            return redirect()->route('apps.pengajuan-ta')->with('success', 'Data berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function show(TugasAkhir $pengajuanTA)
    {
        $bimbingUji = $pengajuanTA->bimbing_uji;
        $pembimbing1 = $bimbingUji->where('jenis', 'pembimbing')->where('urut', 1)->first();
        $pembimbing2 = $bimbingUji->where('jenis', 'pembimbing')->where('urut', 2)->first();
        $penguji1 = $bimbingUji->where('jenis', 'penguji')->where('urut', 1)->first();
        $penguji2 = $bimbingUji->where('jenis', 'penguji')->where('urut', 2)->first();
        $docPengajuan = JenisDokumen::all();

        $data = [
            'title' => 'Detail Pengajuan Tugas Akhir',
            'mods' => 'pengajuan_ta',
            'breadcrumbs' => [
                [
                    'title' => 'Dashboard',
                    'url' => route('apps.dashboard')
                ],
                [
                    'title' => getInfoLogin()->hasRole('Mahasiswa') ? 'Tugas Akhir' : 'Pengajuan Tugas Akhir',
                    'url' => route('apps.pengajuan-ta')
                ],
                [
                    'title' => getInfoLogin()->hasRole('Mahasiswa') ? 'Detail Tugas Akhir' : 'Detail Pengajuan Tugas Akhir',
                    'is_active' => true
                ]
            ],
            'dataTA' => $pengajuanTA,
            'pembimbingPenguji' => $bimbingUji,
            'pembimbing1' => $pembimbing1,
            'pembimbing2' => $pembimbing2,
            'penguji1' => $penguji1,
            'penguji2' => $penguji2,
            'doc' => $docPengajuan,
        ];

        return view('administrator.pengajuan-ta.partials.detail', $data);
    }

    // public function unggah_berkas(TugasAkhir $pengajuanTA, Request $request)
    // {
    //     $request->validate([
    //         'dokumen_pemb_2' => 'nullable|mimes:docx,pdf',
    //     ],[
    //         'file_pemb_2.mimes' => 'Fiel proposal harus dalam format PDF atau DOCX',
    //         'file_pemb_2.max' => 'File proposal melebihi batas upload, maksimal 5MB',
    //     ]);

    //     try {
    //         $data = TugasAkhir::where('id', $pengajuanTA->id)->first();
    //         // dd($data);

    //         if($request->hasFile('dokumen_pemb_2')){
    //             $file = $request->file('dokumen_pemb_2');
    //             $dokumenPemb2 = 'Pembimbing_2_' . rand(0, 999999999) . '.' . $file->getClientOriginalExtension();
    //             $file->move(public_path('storage/files/tugas-akhir'), $dokumenPemb2);
    //             if($pengajuanTA->file_persetujuan_pemb2) {
    //                 File::delete(public_path('storage/files/tugas-akhir/'.$pengajuanTA->file_persetujuan_pemb_2));
    //             }
    //         }

    //         $data->update([
    //             'file_persetujuan_pemb_2' => $dokumenPemb2,
    //         ]);

    //         return redirect()->route('apps.pengajuan-ta')->with('success', 'Berkas berhasil diunggah');
    //     } catch (\Exception $e) {
    //         // dd($e->getMessage());
    //         return redirect()->back()->with('error', $e->getMessage());
    //     }
    // }

    public function accept(TugasAkhir $pengajuanTA, Request $request)
    {
        $request->validate([
            'catatan' => 'nullable'
        ]);

        try {

            $pengajuanTA->update([
                'status' => 'acc',
                'catatan' => $request->catatan
            ]);

            JadwalSeminar::create([
                'tugas_akhir_id' => $pengajuanTA->id,
                'status' => 'belum_terjadwal'
            ]);

            Sidang::create([
                'tugas_akhir_id' => $pengajuanTA->id,
                'status' => 'belum_daftar'
            ]);

            return redirect()->route('apps.pengajuan-ta')->with('success', 'Berhasil menyetujui pengajuan TA');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function reject(TugasAkhir $pengajuanTA, Request $request)
    {
        $request->validate([
            'catatan' => 'nullable'
        ]);

        try {
            $data = TugasAkhir::where('id', $pengajuanTA->id)->first();

            $data->update([
                'status' => 'reject',
                'catatan' => $request->catatan
            ]);

            return redirect()->route('apps.pengajuan-ta')->with('success', 'Berhasil menolak pengajuan TA');
        } catch (\Exception $e) {
            // dd($e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function cancel(TugasAkhir $pengajuanTA, Request $request)
    {
        $request->validate([
            'catatan' => 'nullable'
        ]);

        try {
            $pengajuanTA->update([
                'status' => 'cancel',
                'catatan' => $request->catatan
            ]);

            return redirect()->back()->with('success', 'Pengajuan TA telah di batalkan');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function revisi(TugasAkhir $pengajuanTA, Request $request)
    {
        // dd($request->all());
        $request->validate([
            'catatan' => 'nullable'
        ]);

        try {
            $pengajuanTA->update([
                'status' => 'revisi',
                'catatan' => $request->catatan
            ]);

            return redirect()->back()->with('success', 'Pengajuan TA telah di revisi');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
