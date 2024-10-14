@extends('administrator.layout.main')
@section('content')
    <div class="card">
         <div class="card-body">
            <div class="d-flex">
                <div class="w-100">
                    <h5 class="fw-bold mb-1">{{isset($data->judul) ? $data->judul : '-'}}</h5>
                    <div class="d-flex gap-2 small text-muted">
                        <div class="badge rounded-pill font-size-12 px-2 {{isset($data->status) ? ($data->status == 'acc' ? 'badge-soft-success' : ($data->status == 'draft' ? 'bg-dark-subtle text-body' : 'badge-soft-danger')) : ''}}">{{isset($data->status) ? $data->status : '-'}}</div>
                        |
                        <span><strong>{{isset($data->topik->nama_topik) ? $data->topik->nama_topik : '-'}}</strong> - {{isset($data->jenis_ta->nama_jenis) ? $data->jenis_ta->nama_jenis : '-'}}</span>
                    </div>
                </div>
            </div>
            <hr style="border: 1.5px solid #a1a1a1;">
            <h5 class="fw-bold m-0">Informasi</h5>
            <p class="text-muted mb-0 small">Informasi umum terkait tugas akhir</p>
            <hr>
            <table class="ms-3" cellpadding="4">
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
                    <td>{{isset($data->tipe) ? (($data->tipe == 'I') ? 'Individu' : 'Kelompok') : '-'}}</td>
                </tr>
                <tr>
                    <th>Periode TA</th>
                    <td>:</td>
                    <td>{{isset($data->periode_ta_id) ? $data->periode_ta->nama : '-'}}</td>
                </tr>
            </table>
            <br><br>
            <div class="d-md-flex d-none">
                <div class="w-100 px-4 py-3 fw-bold text-center border-top {{isset($data->status) ? ($data->status == 'draft' ? 'border-primary bg-soft-primary text-primary' : ($data->status == 'acc' ? 'border-success bg-soft-success text-success' : 'border-danger bg-soft-danger text-danger')) : 'border-secondary bg-soft-secondary text-secondary'}}" style="white-space: nowrap">
                    <i class="bx {{$data->status == 'acc' ? 'bx-check' : ($data->status == 'reject' ? 'bx-x' : 'bx-timer')}}"></i> 
                Pengajuan Topik</div>
                <div class="w-100 px-4 py-3 fw-bold text-center border-top {{isset($data->status_seminar) ? ($data->status_seminar == 'draft' ? 'border-primary bg-soft-primary text-primary' : ($data->status_seminar == 'acc' ? 'border-success bg-soft-success text-success' : 'border-danger bg-soft-danger text-danger')) : 'border-secondary bg-soft-secondary text-secondary'}}" style="white-space: nowrap">
                    <i class="bx {{$data->status_seminar == 'acc' ? 'bx-check' : ($data->status_seminar == 'reject' ? 'bx-x' : 'bx-timer')}}"></i> 
                Seminar Proposal</div>
                <div class="w-100 px-4 py-3 fw-bold text-center border-top border-secondary bg-soft-secondary text-secondary" style="white-space: nowrap"><i class="bx bx-timer"></i> Sidang Akhir</div>
            </div>
            <br><br>
            <h5 class="fw-bold m-0">Dokumen - Dokumen</h5>
            <p class="text-muted small">Semua dokumen - dokumen pendukung tugas akhir</p>
            <hr>
            <div class="d-flex flex-wrap">
                <div class="col-md-3 col-sm-6 col-12 border p-3 text-center">
                    <strong>Dokumen Pembimbing 1</strong>
                    @if (isset($data->dokumen_pemb_1))
                    <i class="mdi mdi-file-pdf-box-outline text-danger d-block" style="font-size: 56px;"></i>
                    <a href="{{asset('storage/files/tugas-akhir/'. $data->dokumen_pemb_1)}}" target="_blank" class="btn btn-secondary btn-sm"><i class="bx bx-show-alt"></i> Lihat Dokumen</a>
                    @else
                    <br><br>
                    <br><br><br>
                    <p class="text-muted"><i class="text-danger">*</i>) Belum memiliki dokumen</p>
                    @endif
                </div>
                <div class="col-md-3 col-sm-6 col-12 border p-3 text-center">
                    <strong>Dokumen Pembimbing 2</strong>
                    @if (isset($data->file_persetujuan_pemb_2))
                    <i class="mdi mdi-file-pdf-box-outline text-danger d-block" style="font-size: 56px;"></i>
                    <a href="{{asset('storage/files/tugas-akhir/'. $data->dokumen_pemb_2)}}" target="_blank" class="btn btn-secondary btn-sm"><i class="bx bx-show-alt"></i> Lihat Dokumen</a>
                    @else    
                    <br><br>
                    <br><br><br>
                    <p class="text-muted"><i class="text-danger">*</i>) Belum memiliki dokumen</p>
                    @endif
                </div>
                <div class="col-md-3 col-sm-6 col-12 border p-3 text-center">
                    <strong>Dokumen Ringkasan</strong>
                    @if (isset($data->dokumen_ringkasan))
                    <i class="mdi mdi-file-pdf-box-outline text-danger d-block" style="font-size: 56px;"></i>
                    <a href="{{asset('storage/files/tugas-akhir/'. $data->dokumen_ringkasan)}}" target="_blank" class="btn btn-secondary btn-sm"><i class="bx bx-show-alt"></i> Lihat Dokumen</a>
                    @else
                    <br><br>
                    <br><br><br>
                    <p class="text-muted"><i class="text-danger">*</i>) Belum memiliki dokumen</p>
                    @endif
                </div>
                <div class="col-md-3 col-sm-6 col-12 border p-3 text-center">
                    <strong>Lembar Penilaian</strong>
                    <br><br>
                    <br><br><br>
                    <p class="text-muted"><i class="text-danger">*</i>) Belum memiliki dokumen</p>
                </div>
                <div class="col-md-3 col-sm-6 col-12 border p-3 text-center">
                    <strong>Rekapitulasi Nilai</strong>
                    <br><br>
                    <br><br><br>
                    <p class="text-muted"><i class="text-danger">*</i>) Belum memiliki dokumen</p>
                </div>
                <div class="col-md-3 col-sm-6 col-12 border p-3 text-center">
                    <strong>Berita Acara</strong>
                    <br><br>
                    <br><br><br>
                    <p class="text-muted"><i class="text-danger">*</i>) Belum memiliki dokumen</p>
                </div>
                <div class="col-md-3 col-sm-6 col-12 border p-3 text-center">
                    <strong>Lembar Revisi</strong>
                    <br><br>
                    <br><br><br>
                    <p class="text-muted"><i class="text-danger">*</i>) Belum memiliki dokumen</p>
                </div>
                <div class="col-md-3 col-sm-6 col-12 border p-3 text-center">
                    <strong>File Proposal <Proposal></Proposal></strong>
                    @if (isset($data->file_proposal))
                    <i class="mdi mdi-file-pdf-box-outline text-danger d-block" style="font-size: 56px;"></i>
                    <a href="{{asset('storage/files/tugas-akhir/'. $data->file_propsal)}}" target="_blank" class="btn btn-secondary btn-sm"><i class="bx bx-show-alt"></i> Lihat Dokumen</a>
                    @else    
                    <br><br>
                    <br><br><br>
                    <p class="text-muted"><i class="text-danger">*</i>) Belum memiliki dokumen</p>
                    @endif
                </div>
                <div class="col-md-3 col-sm-6 col-12 border p-3 text-center">
                    <strong>Lembar Pengesahan <Proposal></Proposal></strong>
                    @if (isset($data->file_pengesahan))
                    <i class="mdi mdi-file-pdf-box-outline text-danger d-block" style="font-size: 56px;"></i>
                    <a href="{{asset('storage/files/tugas-akhir/'. $data->file_pengesahan)}}" target="_blank" class="btn btn-secondary btn-sm"><i class="bx bx-show-alt"></i> Lihat Dokumen</a>
                    @else    
                    <br><br>
                    <br><br><br>
                    <p class="text-muted"><i class="text-danger">*</i>) Belum memiliki dokumen</p>
                    @endif
                </div>
            </div>
         </div>
    </div>
@endsection