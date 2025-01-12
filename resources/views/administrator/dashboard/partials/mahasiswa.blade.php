<style>

</style>

<div class="row">
    {{-- <div class="col-md-4 col-sm-4 col-12">
        <div class="card shadow-sm mb-4"
            style="border-left: 3px solid {{ $tugasAkhir->status == 'acc' ? '#1db45c' : ($tugasAkhir->status == 'draft' || $tugasAkhir->status == 'revisi' ? '#ebe831' : '#ff5b5b') }}">
            <div class="card-body p-3">
                <div class="d-flex align-items-center justify-content-between gap-3">
                    <div style="width: 55px;height: 55px;font-size: 2rem"
                        class="bg-soft-{{ $tugasAkhir->status == 'acc' ? 'success' : ($tugasAkhir->status == 'draft' || $tugasAkhir->status == 'revisi' ? 'warning' : 'danger') }} rounded d-flex align-items-center justify-content-center text-{{ $tugasAkhir->status == 'acc' ? 'success' : ($tugasAkhir->status == 'draft' || $tugasAkhir->status == 'revisi' ? 'warning' : 'danger') }}">
                        <i
                            class="{{ $tugasAkhir->status == 'acc' ? 'mdi mdi-file-document-box-check-outline' : ($tugasAkhir->status == 'draft' || $tugasAkhir->status == 'revisi' ? 'mdi mdi-calendar-clock' : 'mdi mdi-file-alert-outline') }}"></i>
                    </div>
                    <div class="col">
                        <span class="text-muted">Pengajuan TA</span>
                        <h5
                            class="m-0 my-1 fw-bold text-{{ $tugasAkhir->status == 'acc' ? 'success' : ($tugasAkhir->status == 'draft' || $tugasAkhir->status == 'revisi' ? 'warning' : 'danger') }}">
                            {{ $tugasAkhir->status == 'acc' ? 'Sudah Disetujui' : ($tugasAkhir->status == 'draft' || $tugasAkhir->status == 'revisi' ? 'Sedang Berlangsung' : 'Ditolak/Tidak Dilanjutkan') }}
                        </h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-sm-4 col-12">
        <div class="card shadow-sm mb-4"
            style="border-left: 3px solid {{ $tugasAkhir->jadwal_seminar->status == 'telah_seminar' ? '#1db45c' : ($tugasAkhir->jadwal_seminar->status == 'sudah_terjadwal' || $tugasAkhir->jadwal_seminar->status == 'belum_terjadwal' ? '#ebe831' : (is_null($tugasAkhir->jadwal_seminar->status) ? '#b4b4b4' : '#ff5b5b')) }}">
            <div class="card-body p-3">
                <div class="d-flex align-items-center justify-content-between gap-3">
                    <div style="width: 55px;height: 55px;font-size: 2rem"
                        class="bg-soft-{{ $tugasAkhir->jadwal_seminar->status == 'telah_seminar' ? 'success' : ($tugasAkhir->jadwal_seminar->status == 'sudah_terjadwal' || $tugasAkhir->jadwal_seminar->status == 'belum_terjadwal' ? 'warning' : (is_null($tugasAkhir->jadwal_seminar->status) ? 'secondary' : 'danger')) }} rounded d-flex align-items-center justify-content-center text-{{ $tugasAkhir->jadwal_seminar->status == 'telah_seminar' ? 'success' : ($tugasAkhir->jadwal_seminar->status == 'sudah_terjadwal' || $tugasAkhir->jadwal_seminar->status == 'belum_terjadwal' ? 'warning' : (is_null($tugasAkhir->jadwal_seminar->status) ? 'secondary' : 'danger')) }}">
                        <i
                            class="{{ $tugasAkhir->jadwal_seminar->status == 'telah_seminar' ? 'mdi mdi-account-check' : ($tugasAkhir->jadwal_seminar->status == 'sudah_terjadwal' || $tugasAkhir->jadwal_seminar->status == 'belum_terjadwal' ? 'mdi mdi-calendar-clock' : ($tugasAkhir->jadwal_seminar->status == 'belum_terjadwal' ? 'mdi mdi-account-alert' : 'mdi mdi-file-alert-outline')) }}"></i>
                    </div>
                    <div class="col">
                        <span class="text-muted">Seminar Proposal</span>
                        <h5
                            class="m-0 my-1 fw-bold text-{{ $tugasAkhir->jadwal_seminar->status == 'telah_seminar' ? 'success' : ($tugasAkhir->jadwal_seminar->status == 'sudah_terjadwal' || $tugasAkhir->jadwal_seminar->status == 'belum_terjadwal' ? 'warning' : (is_null($tugasAkhir->jadwal_seminar->status) ? 'secondary' : 'danger')) }}">
                            {{ $tugasAkhir->jadwal_seminar->status == 'telah_seminar' ? 'Sudah Disetujui' : ($tugasAkhir->jadwal_seminar->status == 'sudah_terjadwal' || $tugasAkhir->jadwal_seminar->status == 'belum_terjadwal' ? 'Sedang Berlangsung' : (is_null($tugasAkhir->jadwal_seminar->status) ? 'Belum Daftar' : 'Ditolak/Tidak Dilanjutkan')) }}
                        </h5>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
     {{-- <div class="col-md-4 col-sm-4 col-12">
        <div class="card shadow-sm mb-4"
            style="border-left: 3px solid {{ !is_null($tugasAkhir->sidang) && $tugasAkhir->sidang->status == 'telah_sidang' ? '#1db45c' : (!is_null($tugasAkhir->sidang) && $tugasAkhir->sidang->status == 'sudah_terjadwal' ? '#ebe831' : ((!is_null($tugasAkhir->sidang) && $tugasAkhir->sidang->status == 'belum_daftar') || is_null($tugasAkhir->sidang) ? '#b4b4b4' : '#ff5b5b')) }}">
            <div class="card-body p-3">
                <div class="d-flex align-items-center justify-content-between gap-3">
                    <div style="width: 55px;height: 55px;font-size: 2rem"
                        class="bg-soft-{{ !is_null($tugasAkhir->sidang) && $tugasAkhir->sidang->status == 'telah_sidang' ? 'success' : (!is_null($tugasAkhir->sidang) && $tugasAkhir->sidang->status == 'sudah_terjadwal' ? 'warning' : ((!is_null($tugasAkhir->sidang) && $tugasAkhir->sidang->status == 'belum_daftar') || is_null($tugasAkhir->sidang) ? 'secondary' : 'danger')) }} rounded d-flex align-items-center justify-content-center text-{{ !is_null($tugasAkhir->sidang) && $tugasAkhir->sidang->status == 'telah_sidang' ? 'success' : (!is_null($tugasAkhir->sidang) && $tugasAkhir->sidang->status == 'sudah_terjadwal' ? 'warning' : ((!is_null($tugasAkhir->sidang) && $tugasAkhir->sidang->status == 'belum_daftar') || is_null($tugasAkhir->sidang) ? 'secondary' : 'danger')) }}">
                        <i
                            class="{{ !is_null($tugasAkhir->sidang) && $tugasAkhir->sidang == 'telah_sidang' ? 'mdi mdi-document-box-check-outline' : (!is_null($tugasAkhir->sidang) && $tugasAkhir->sidang->status == 'sudah_terjadwal' ? 'mdi mdi-calendar-clock' : ((!is_null($tugasAkhir->sidang) && $tugasAkhir->sidang->status == 'belum_daftar') || is_null($tugasAkhir->sidang) ? 'mdi mdi-account-alert' : 'mdi mdi-file-alert-outline')) }}"></i>
                    </div>
                    <div class="col">
                        <span class="text-muted">Sidang Akhir</span>
                        <h5
                            class="m-0 my-1 fw-bold text-{{ !is_null($tugasAkhir->sidang) && $tugasAkhir->sidang->status == 'telah_sidang' ? 'success' : (!is_null($tugasAkhir->sidang) && $tugasAkhir->sidang->status == 'sudah_terjadwal' ? 'warning' : ((!is_null($tugasAkhir->sidang) && $tugasAkhir->sidang->status == 'belum_daftar') || is_null($tugasAkhir->sidang) ? 'secondary' : 'danger')) }}">
                            {{ !is_null($tugasAkhir->sidang) && $tugasAkhir->sidang->status == 'telah_sidang' ? 'Sudah Disetujui' : (!is_null($tugasAkhir->sidang) && $tugasAkhir->sidang->status == 'sudah_terjadwal' ? 'Sedang Berlangsung' : ((!is_null($tugasAkhir->sidang) && $tugasAkhir->sidang->status == 'belum_daftar') || is_null($tugasAkhir->sidang) ? 'Belum Daftar' : 'Ditolak/Tidak Dilanjutkan')) }}
                        </h5>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    <div class="col-md-4 col-sm-4 col-12">
        <div class="card shadow-sm mb-4"
            style="border-left: 3px solid {{ is_null($tugasAkhir) ? '#b4b4b4' : ($tugasAkhir->status == 'acc' ? '#1db45c' : ($tugasAkhir->status == 'draft' || $tugasAkhir->status == 'revisi' ? '#ebe831' : '#ff5b5b')) }}">
            <div class="card-body p-3">
                <div class="d-flex align-items-center justify-content-between gap-3">
                    <div style="width: 55px;height: 55px;font-size: 2rem"
                        class="bg-soft-{{ is_null($tugasAkhir) ? 'secondary' : ($tugasAkhir->status == 'acc' ? 'success' : ($tugasAkhir->status == 'draft' || $tugasAkhir->status == 'revisi' ? 'warning' : 'danger')) }} rounded d-flex align-items-center justify-content-center text-{{ is_null($tugasAkhir) ? 'secondary' : ($tugasAkhir->status == 'acc' ? 'success' : ($tugasAkhir->status == 'draft' || $tugasAkhir->status == 'revisi' ? 'warning' : 'danger')) }}">
                        <i
                            class="{{ is_null($tugasAkhir) ? 'mdi mdi-alert-circle-outline' : ($tugasAkhir->status == 'acc' ? 'mdi mdi-file-document-box-check-outline' : ($tugasAkhir->status == 'draft' || $tugasAkhir->status == 'revisi' ? 'mdi mdi-calendar-clock' : 'mdi mdi-file-alert-outline')) }}"></i>
                    </div>
                    <div class="col">
                        <span class="text-muted">Pengajuan TA</span>
                        <h5
                            class="m-0 my-1 fw-bold text-{{ is_null($tugasAkhir) ? 'secondary' : ($tugasAkhir->status == 'acc' ? 'success' : ($tugasAkhir->status == 'draft' || $tugasAkhir->status == 'revisi' ? 'warning' : 'danger')) }}">
                            {{ is_null($tugasAkhir) ? 'Tidak Ada Data' : ($tugasAkhir->status == 'acc' ? 'Sudah Disetujui' : ($tugasAkhir->status == 'draft' || $tugasAkhir->status == 'revisi' ? 'Sedang Berlangsung' : 'Ditolak/Tidak Dilanjutkan')) }}
                        </h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-sm-4 col-12">
        <div class="card shadow-sm mb-4"
            style="border-left: 3px solid {{ is_null($tugasAkhir) || is_null($tugasAkhir->jadwal_seminar) ? '#b4b4b4' : ($tugasAkhir->jadwal_seminar->status == 'telah_seminar' ? '#1db45c' : ($tugasAkhir->jadwal_seminar->status == 'sudah_terjadwal' || $tugasAkhir->jadwal_seminar->status == 'belum_terjadwal' ? '#ebe831' : '#ff5b5b')) }}">
            <div class="card-body p-3">
                <div class="d-flex align-items-center justify-content-between gap-3">
                    <div style="width: 55px;height: 55px;font-size: 2rem"
                        class="bg-soft-{{ is_null($tugasAkhir) || is_null($tugasAkhir->jadwal_seminar) ? 'secondary' : ($tugasAkhir->jadwal_seminar->status == 'telah_seminar' ? 'success' : ($tugasAkhir->jadwal_seminar->status == 'sudah_terjadwal' || $tugasAkhir->jadwal_seminar->status == 'belum_terjadwal' ? 'warning' : 'danger')) }} rounded d-flex align-items-center justify-content-center text-{{ is_null($tugasAkhir) || is_null($tugasAkhir->jadwal_seminar) ? 'secondary' : ($tugasAkhir->jadwal_seminar->status == 'telah_seminar' ? 'success' : ($tugasAkhir->jadwal_seminar->status == 'sudah_terjadwal' || $tugasAkhir->jadwal_seminar->status == 'belum_terjadwal' ? 'warning' : 'danger')) }}">
                        <i
                            class="{{ is_null($tugasAkhir) || is_null($tugasAkhir->jadwal_seminar) ? 'mdi mdi-alert-circle-outline' : ($tugasAkhir->jadwal_seminar->status == 'telah_seminar' ? 'mdi mdi-account-check' : ($tugasAkhir->jadwal_seminar->status == 'sudah_terjadwal' || $tugasAkhir->jadwal_seminar->status == 'belum_terjadwal' ? 'mdi mdi-calendar-clock' : 'mdi mdi-file-alert-outline')) }}"></i>
                    </div>
                    <div class="col">
                        <span class="text-muted">Seminar Proposal</span>
                        <h5
                            class="m-0 my-1 fw-bold text-{{ is_null($tugasAkhir) || is_null($tugasAkhir->jadwal_seminar) ? 'secondary' : ($tugasAkhir->jadwal_seminar->status == 'telah_seminar' ? 'success' : ($tugasAkhir->jadwal_seminar->status == 'sudah_terjadwal' || $tugasAkhir->jadwal_seminar->status == 'belum_terjadwal' ? 'warning' : 'danger')) }}">
                            {{ is_null($tugasAkhir) || is_null($tugasAkhir->jadwal_seminar) ? 'Tidak Ada Data' : ($tugasAkhir->jadwal_seminar->status == 'telah_seminar' ? 'Sudah Disetujui' : ($tugasAkhir->jadwal_seminar->status == 'sudah_terjadwal' || $tugasAkhir->jadwal_seminar->status == 'belum_terjadwal' ? 'Sedang Berlangsung' : 'Ditolak/Tidak Dilanjutkan')) }}
                        </h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-sm-4 col-12">
        <div class="card shadow-sm mb-4"
            style="border-left: 3px solid {{ isset($tugasAkhir->sidang) && $tugasAkhir->sidang->status == 'telah_sidang' ? '#1db45c' : (isset($tugasAkhir->sidang) && $tugasAkhir->sidang->status == 'sudah_terjadwal' ? '#ebe831' : (isset($tugasAkhir->sidang) && $tugasAkhir->sidang->status == 'belum_daftar' ? '#b4b4b4' : '#ff5b5b')) }}">
            <div class="card-body p-3">
                <div class="d-flex align-items-center justify-content-between gap-3">
                    <div style="width: 55px;height: 55px;font-size: 2rem"
                        class="bg-soft-{{ isset($tugasAkhir->sidang) && $tugasAkhir->sidang->status == 'telah_sidang' ? 'success' : (isset($tugasAkhir->sidang) && $tugasAkhir->sidang->status == 'sudah_terjadwal' ? 'warning' : (isset($tugasAkhir->sidang) && $tugasAkhir->sidang->status == 'belum_daftar' ? 'secondary' : 'danger')) }} rounded d-flex align-items-center justify-content-center text-{{ isset($tugasAkhir->sidang) && $tugasAkhir->sidang->status == 'telah_sidang' ? 'success' : (isset($tugasAkhir->sidang) && $tugasAkhir->sidang->status == 'sudah_terjadwal' ? 'warning' : (isset($tugasAkhir->sidang) && $tugasAkhir->sidang->status == 'belum_daftar' ? 'secondary' : 'danger')) }}">
                        <i
                            class="{{ isset($tugasAkhir->sidang) && $tugasAkhir->sidang->status == 'telah_sidang' ? 'mdi mdi-document-box-check-outline' : (isset($tugasAkhir->sidang) && $tugasAkhir->sidang->status == 'sudah_terjadwal' ? 'mdi mdi-calendar-clock' : (isset($tugasAkhir->sidang) && $tugasAkhir->sidang->status == 'belum_daftar' ? 'mdi mdi-account-alert' : 'mdi mdi-file-alert-outline')) }}"></i>
                    </div>
                    <div class="col">
                        <span class="text-muted">Sidang Akhir</span>
                        <h5
                            class="m-0 my-1 fw-bold text-{{ isset($tugasAkhir->sidang) && $tugasAkhir->sidang->status == 'telah_sidang' ? 'success' : (isset($tugasAkhir->sidang) && $tugasAkhir->sidang->status == 'sudah_terjadwal' ? 'warning' : (isset($tugasAkhir->sidang) && $tugasAkhir->sidang->status == 'belum_daftar' ? 'secondary' : 'danger')) }}">
                            {{ isset($tugasAkhir->sidang) ? ($tugasAkhir->sidang->status == 'telah_sidang' ? 'Sudah Disetujui' : ($tugasAkhir->sidang->status == 'sudah_terjadwal' ? 'Sedang Berlangsung' : ($tugasAkhir->sidang->status == 'belum_daftar' ? 'Belum Daftar' : 'Ditolak/Tidak Dilanjutkan'))) : 'Tidak Ada Data' }}
                        </h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</div>

<div class="row">
    <div class="col-md-4 col-sm-5 col-12">
        <div class="card shadow-sm mb-4" style="height: calc(100% - 1.5rem)">
            <div class="card-body">
                <h6 class="fw-bold m-0">Jadwal Seminar/Sidang Akhir</h6>
                <hr>
                <div class="my-5 py-5 text-center">
                    <div class="col-md-7 col-sm-10 col-10 mx-auto">
                        <img src="{{ asset('assets/images/no-data.png') }}" width="100%" alt="">
                    </div>
                    <p class="text-muted mt-3">Tidak ada jadwal seminar/sidang akhir yang ditemukan.</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-8 col-sm-7 col-12">
        <div class="card shadow-sm mb-4" style="height: calc(100% - 1.5rem)">
            <div class="card-body">
                <h6 class="fw-bold m-0">Tawaran Topik</h6>
                <hr>
                <div class="my-5 py-5 text-center">
                    <div class="col-md-4 col-sm-7 col-10 mx-auto">
                        <img src="{{ asset('assets/images/no-data.png') }}" width="100%" alt="">
                    </div>
                    <p class="text-muted mt-3">Tidak ada tawaran topik yang ditemukan.</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="card shadow-sm mb-4" style="height: calc(100% - 1.5rem)">
            <div class="card-body">
                <h6 class="fw-bold m-0">Daftar Kuota Dosen</h6>
                <hr>
                <div class="my-5 py-5 text-center">
                    <div class="col-md-3 col-sm-6 col-10 mx-auto">
                        <img src="{{ asset('assets/images/no-data.png') }}" width="100%" alt="">
                    </div>
                    <p class="text-muted mt-3">Tidak ada daftar kuota dosen yang ditemukan.</p>
                </div>
            </div>
        </div>
    </div>
</div>
