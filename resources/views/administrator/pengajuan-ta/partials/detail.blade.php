@extends('administrator.layout.main')
@section('content')
    <div class="card">
        {{-- <div class="card-header">
            <h5  class="fw-bold">
                sistem rekomandasi pencarian buku
            </h5>
            <div class="badge badge-soft-primary font-size-12">status</div>
            <hr>
        </div>
         --}}
         <div class="card-body">
            <div class="d-flex">
                <div class="w-100">
                    <h5 class="fw-bold mb-1">Sistem Rekomendasi Pencarian Buku</h5>
                    <div class="d-flex gap-2 small text-muted">
                        <div class="badge badge-soft-primary rounded-pill font-size-12 px-2">Acc</div>
                        |
                        <span><strong>Penelitian</strong> - Sistem Pengambilan Keputusan</span>
                    </div>
                </div>
                <button class="btn btn-rounded btn-light bx bx-dots-horizontal fs-4" style="width: 45px;height: 45px;"></button>
            </div>
            <hr style="border: 1.5px solid #a1a1a1;">
            <h5 class="fw-bold m-0">Informasi</h5>
            <p class="text-muted mb-0 small">Informasi umum terkait tugas akhir</p>
            <hr>
            <table class="ms-3" cellpadding="4">
                <tr>
                    <th>Pembimbing 1</th>
                    <td>:</td>
                    <td>Lutfi Hakim, S.Pd., M.T.</td>
                </tr>
                <tr>
                    <th>Pembimbing 2</th>
                    <td>:</td>
                    <td>-</td>
                </tr>
                <tr>
                    <th>Penguji 1</th>
                    <td>:</td>
                    <td>-</td>
                </tr>
                <tr>
                    <th>Penguji 2</th>
                    <td>:</td>
                    <td>-</td>
                </tr>
                <tr>
                    <th>Tipe</th>
                    <td>:</td>
                    <td>Individu</td>
                </tr>
                <tr>
                    <th>Periode TA</th>
                    <td>:</td>
                    <td>2023/2024</td>
                </tr>
            </table>
            <br><br>
            <div class="d-md-flex d-none">
                <div class="w-100 bg-soft-success text-success px-4 py-3 fw-bole text-center border-success border-top" style="white-space: nowrap"><i class="bx bx-check"></i> Pengajuan Topik</div>
                <div class="w-100 bg-soft-danger text-danger px-4 py-3 fw-bole text-center border-danger border-top" style="white-space: nowrap"><i class="mdi mdi-close-circle"></i> Penyusunan Proposal</div>
                <div class="w-100 bg-light text-muted px-4 py-3 fw-bole text-center border-top border-secondary" style="white-space: nowrap"><i class="bx bx-check"></i> Seminar Proposal</div>
                <div class="w-100 bg-light text-muted px-4 py-3 fw-bole text-center border-top border-secondary" style="white-space: nowrap"><i class="bx bx-check"></i> Penyusunan Tugas Akhir</div>
                <div class="w-100 bg-light text-muted px-4 py-3 fw-bole text-center border-top border-secondary" style="white-space: nowrap"><i class="bx bx-check"></i> Sidang Akhir</div>
            </div>
            <br><br>
            <h5 class="fw-bold m-0">Dokumen - Dokumen</h5>
            <p class="text-muted small">Semua dokumen - dokumen pendukung tugas akhir</p>
            <hr>
            <div class="d-flex flex-wrap">
                <div class="col-md-3 col-sm-6 col-12 border p-3 text-center">
                    <strong>Dokumen Pembimbing 1</strong>
                    <i class="mdi mdi-file-pdf-box-outline text-danger d-block" style="font-size: 56px;"></i>
                    <button class="btn btn-secondary btn-sm"><i class="bx bx-download"></i> Download Dokumen</button>
                </div>
                <div class="col-md-3 col-sm-6 col-12 border p-3 text-center">
                    <strong>Dokumen Pembimbing 2</strong>
                    <br><br>
                    <br><br><br>
                    <p class="text-muted"><i class="text-danger">*</i>) Belum memiliki dokumen</p>
                </div>
                <div class="col-md-3 col-sm-6 col-12 border p-3 text-center">
                    <strong>Dokumen Pembimbing 1</strong>
                    <i class="mdi mdi-file-pdf-box-outline text-danger d-block" style="font-size: 56px;"></i>
                    <button class="btn btn-secondary btn-sm"><i class="bx bx-download"></i> Download Dokumen</button>
                </div>
                <div class="col-md-3 col-sm-6 col-12 border p-3 text-center">
                    <strong>Dokumen Proposal</strong>
                    <br><br>
                    <br><br><br>
                    <p class="text-muted"><i class="text-danger">*</i>) Belum memiliki dokumen</p>
                </div>
            </div>
         </div>
    </div>
@endsection