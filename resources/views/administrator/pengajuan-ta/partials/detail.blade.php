@extends('administrator.layout.main')
@section('content')
    <div class="card">
         <div class="card-body">
            <div class="d-flex">
                <div class="col-md-10 col-12">
                    <h5 class="fw-bold mb-1">{{isset($dataTA->judul) ? $dataTA->judul : '-'}}</h5>
                    <div class="d-flex gap-2 small text-muted">
                        <div class="badge rounded-pill font-size-12 px-2 {{isset($dataTA->status) ? ($dataTA->status == 'acc' ? 'badge-soft-success' : ($dataTA->status == 'draft' ? 'bg-dark-subtle text-body' : 'badge-soft-danger')) : ''}}">{{isset($dataTA->status) ? $dataTA->status : '-'}}</div>
                        |
                        <span><strong>{{isset($dataTA->topik->nama_topik) ? $dataTA->topik->nama_topik : '-'}}</strong> - {{isset($dataTA->jenis_ta->nama_jenis) ? $dataTA->jenis_ta->nama_jenis : '-'}}</span>
                    </div>
                </div>
                @if (getInfoLogin()->hasRole('Kaprodi'))
                    @if ($dataTA->status == 'draft')
                        <div class="col-md-2 col-12 text-end">
                            @can('acc-pengajuan-tugas-akhir')
                                <button
                                    onclick="acceptTA('{{ $dataTA->id }}', '{{ route('apps.pengajuan-ta.accept', $dataTA->id) }}')"
                                    class="btn btn-outline-primary btn-sm mx-1 my-1"
                                    title="Acc">Setujui</i></button>
                            @endcan
                            <button
                                onclick="rejectTA('{{ $dataTA->id }}', '{{ route('apps.pengajuan-ta.reject', $dataTA->id) }}')"
                                class="btn btn-outline-danger btn-sm mx-1 my-1"
                                title="Reject">Tolak</button>
                        </div>
                    @endif
                @endif
            </div>
            <hr style="border: 1.5px solid #a1a1a1;">
            <h5 class="fw-bold m-0">Informasi</h5>
            <p class="text-muted mb-0 small">Informasi umum terkait tugas akhir</p>
            <hr>
            <table class="ms-3" cellpadding="4">
                <tr>
                    <th>Nama Mahasiswa</th>
                    <td>:</td>
                    <td>{{isset($dataTA->mahasiswa) ? $dataTA->mahasiswa->nama_mhs : '-'}}</td>
                </tr>
                <tr>
                    <th>Pembimbing 1</th>
                    <td>:</td>
                    <td>{{isset($pembimbing1) ? $pembimbing1->dosen->name : '-'}}</td>
                </tr>
                <tr>
                    <th>Pembimbing 2</th>
                    <td>:</td>
                    <td>{{isset($pembimbing2) ? $pembimbing2->dosen->name : '-'}}</td>
                </tr>
                <tr>
                    <th>Penguji 1</th>
                    <td>:</td>
                    <td>{{isset($penguji1) ? $penguji1->dosen->name : '-'}}</td>
                </tr>
                <tr>
                    <th>Penguji 2</th>
                    <td>:</td>
                    <td>{{isset($penguji2) ? $penguji2->dosen->name : '-'}}</td>
                </tr>
                <tr>
                    <th>Tipe</th>
                    <td>:</td>
                    <td>{{isset($dataTA->tipe) ? (($dataTA->tipe == 'I') ? 'Individu' : 'Kelompok') : '-'}}</td>
                </tr>
                <tr>
                    <th>Periode TA</th>
                    <td>:</td>
                    <td>{{isset($dataTA->periode_ta_id) ? $dataTA->periode_ta->nama : '-'}}</td>
                </tr>
            </table>
            <br><br>
            <div class="d-flex flex-column flex-md-row">
                <div class="w-100 px-4 py-3 fw-bold text-center border-top {{isset($dataTA->status) ? ($dataTA->status == 'draft' ? 'border-primary bg-soft-primary text-primary' : ($dataTA->status == 'acc' ? 'border-success bg-soft-success text-success' : 'border-danger bg-soft-danger text-danger')) : 'border-secondary bg-soft-secondary text-secondary'}}" style="white-space: nowrap">
                    <i class="bx {{$dataTA->status == 'acc' ? 'bx-check' : ($dataTA->status == 'reject' ? 'bx-x' : 'bx-timer')}}"></i> 
                    Pengajuan Topik
                    <br>
                    <span class="small">{{$dataTA->status == 'acc' ? 'Selesai' : ($dataTA->status == 'reject' ? 'Ditolak' : ($dataTA->status == 'draft' ? 'Sedang Berlangsung': 'Tidak Dilanjutkan'))}}</span>
                </div>
                {{-- <div class="w-100 px-4 py-3 fw-bold text-center border-top {{!is_null($dataTA->status_seminar) || $dataTA->status == 'acc' ? ($dataTA->status_seminar == 'revisi' || $dataTA->status == 'acc' ? 'border-primary bg-soft-primary text-primary' : ($dataTA->status_seminar == 'acc' && $dataTA->status_pemberkasan == 'sudah_lengkap' ? 'border-success bg-soft-success text-success' : 'border-danger bg-soft-danger text-danger')) : 'border-secondary bg-soft-secondary text-secondary'}}" style="white-space: nowrap"> --}}
                <div class="w-100 px-4 py-3 fw-bold text-center border-top {{ !is_null($dataTA->status) && $dataTA->status == 'acc' ? ($dataTA->status_seminar == 'reject' ? 'border-danger bg-soft-danger text-danger' : (($dataTA->status_seminar == 'acc' || $dataTA->status_seminar == 'revisi') && $dataTA->status_pemberkasan == 'sudah_lengkap' || !is_null($dataTA->status_sidang) && ($dataTA->status_seminar == 'acc' || $dataTA->status_seminar == 'revisi') ? 'border-success bg-soft-success text-success' : 'border-primary bg-soft-primary text-primary')) : 'border-secondary bg-soft-secondary text-secondary' }}" style="white-space: nowrap">
                    <i class="bx {{($dataTA->status_seminar == 'acc' || $dataTA->status_seminar == 'revisi') && $dataTA->status_pemberkasan == 'sudah_lengkap' || !is_null($dataTA->status_sidang) ? 'bx-check' : ($dataTA->status_seminar == 'reject' ? 'bx-x' : 'bx-timer')}}"></i> 
                    Seminar Proposal
                    <br>
                    <span class="small">{{ !is_null($dataTA->status) && $dataTA->status == 'acc' ? (($dataTA->status_seminar == 'acc' || $dataTA->status_seminar == 'revisi') && $dataTA->status_pemberkasan == 'sudah_lengkap' || !is_null($dataTA->status_sidang) ? 'Selesai' : ($dataTA->status_seminar == 'reject' ? 'Ditolak' : 'Sedang Berlangsung')) : '' }}</span>
                </div>
                <div class="w-100 px-4 py-3 fw-bold text-center border-top {{ !is_null($dataTA->status_seminar) && ($dataTA->status_seminar == 'acc' || $dataTA->status_seminar == 'revisi') && $dataTA->status_pemberkasan == 'sudah_lengkap' || !is_null($dataTA->status_sidang) ? ($dataTA->status_sidang == 'reject' ? 'border-danger bg-soft-danger text-danger' : (($dataTA->status_sidang == 'acc' || $dataTA->status_sidang == 'revisi') && $dataTA->status_pemberkasan == 'sudah_lengkap' ? 'border-success bg-soft-success text-success' : 'border-primary bg-soft-primary text-primary')) : 'border-secondary bg-soft-secondary text-secondary' }}" style="white-space: nowrap">
                    <i class="bx {{($dataTA->status_sidang == 'acc' || $dataTA->status_sidang == 'revisi') && $dataTA->status_pemberkasan == 'sudah_lengkap' && ($dataTA->status_sidang == 'acc' || $dataTA->status_sidang == 'revisi') ? 'bx-check' : ($dataTA->status_sidang == 'reject' ? 'bx-x' : 'bx-timer')}}"></i> 
                    Sidang Akhir
                    <br>
                    <span class="small">{{ !is_null($dataTA->status_seminar) && $dataTA->status_seminar == 'acc' && $dataTA->status_pemberkasan == 'sudah_lengkap' || !is_null($dataTA->status_sidang) ? (($dataTA->status_sidang == 'acc' || $dataTA->status_sidang == 'revisi') && $dataTA->status_pemberkasan == 'sudah_lengkap' ? 'Selesai' : ($dataTA->status_sidang == 'reject' ? 'Ditolak' : 'Sedang Berlangsung')) : '' }}</span>
                </div>
            </div>
            <br><br>
            <h5 class="fw-bold m-0">Dokumen - Dokumen</h5>
            <p class="text-muted small">Semua dokumen - dokumen pendukung tugas akhir</p>
            <hr>
            <div class="accordion" id="accordionExample">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="HeadingPengajuanTA">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePengajuanTA" aria-expanded="true" aria-controls="collapsePengajuanTA">
                            Pengajuan Tugas Akhir
                        </button>
                    </h2>
                    <div id="collapsePengajuanTA" class="accordion-collapse collapse show" aria-labelledby="headingPengajuanTA" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <div class="d-flex flex-wrap">
                                @foreach ($doc->where('jenis', 'pendaftaran')->sortBy(['nama', 'asc']) as $item)
                                    <div class="col-md-3 col-sm-6 col-12 border p-3 text-center">
                                        <strong>{{ ucwords(strtolower($item->nama)) }}</strong>
                                        @if ($item->pemberkasan()->where('tugas_akhir_id', $dataTA->id)->exists())
                                        <i class="mdi mdi-file-pdf-box-outline text-danger d-block" style="font-size: 56px;"></i>
                                        <a href="{{asset('storage/files/pemberkasan/'. $item->pemberkasan->where('tugas_akhir_id', $dataTA->id)->first()->filename)}}" target="_blank" class="btn btn-secondary btn-sm"><i class="bx bx-show-alt"></i> Lihat Dokumen</a>
                                        @else
                                        <br><br>
                                        <br><br><br>
                                        <p class="text-muted"><i class="text-danger">*</i>) Belum memiliki dokumen</p>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="HeadingSeminar">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSeminar" aria-expanded="true" aria-controls="collapseSeminar">
                            Seminar Proposal
                        </button>
                    </h2>
                    <div id="collapseSeminar" class="accordion-collapse collapse" aria-labelledby="headingSeminar" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <div class="d-flex flex-wrap">
                                @foreach ($doc->whereIn('jenis', ['pra_seminar', 'seminar'])->sortBy(['nama', 'asc']) as $item)
                                    <div class="col-md-3 col-sm-6 col-12 border p-3 text-center">
                                        <strong>{{ ucwords(strtolower($item->nama)) }}</strong>
                                        @if ($item->pemberkasan()->where('tugas_akhir_id', $dataTA->id)->exists())
                                        <i class="mdi mdi-file-pdf-box-outline text-danger d-block" style="font-size: 56px;"></i>
                                        <a href="{{asset('storage/files/pemberkasan/'. $item->pemberkasan->where('tugas_akhir_id', $dataTA->id)->first()->filename)}}" target="_blank" class="btn btn-secondary btn-sm"><i class="bx bx-show-alt"></i> Lihat Dokumen</a>
                                        @else
                                        <br><br>
                                        <br><br><br>
                                        <p class="text-muted"><i class="text-danger">*</i>) Belum memiliki dokumen</p>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="HeadingSidang">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSidang" aria-expanded="true" aria-controls="collapseSidang">
                            Sidang Akhir
                        </button>
                    </h2>
                    <div id="collapseSidang" class="accordion-collapse collapse" aria-labelledby="headingSidang" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <div class="d-flex flex-wrap">
                                @foreach ($doc->where('jenis', 'pra_sidang', 'sidang')->sortBy(['nama', 'asc']) as $item)
                                    <div class="col-md-3 col-sm-6 col-12 border p-3 text-center">
                                        <strong>{{ ucwords(strtolower($item->nama)) }}</strong>
                                        @if ($item->pemberkasan()->where('tugas_akhir_id', $dataTA->id)->exists())
                                        <i class="mdi mdi-file-pdf-box-outline text-danger d-block" style="font-size: 56px;"></i>
                                        <a href="{{asset('storage/files/pemberkasan/'. $item->pemberkasan->where('tugas_akhir_id', $dataTA->id)->first()->filename)}}" target="_blank" class="btn btn-secondary btn-sm"><i class="bx bx-show-alt"></i> Lihat Dokumen</a>
                                        @else
                                        <br><br>
                                        <br><br><br>
                                        <p class="text-muted"><i class="text-danger">*</i>) Belum memiliki dokumen</p>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
         </div>
    </div>

    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalAccLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0"></h5>
                    <button type="button" class="btn btn-close" data-bs-dismiss="modal" aria-label="close"></button>
                </div>
                <form action="" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="">Catatan</label>
                            <textarea name="catatan" class="form-control"></textarea>
                            <i>Silahkan tuliskan catatan (opsional):</i>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary waves-effect waves-light">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection