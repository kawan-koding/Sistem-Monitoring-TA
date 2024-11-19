@extends('layout.app')
@section('content')

    <section id="hero-fullscreen" class="hero-fullscreen d-flex align-items-center"
        style="background: url('{{ asset('storage/images/settings/' . getSetting('app_bg')) }}') center center; width: 100%; min-height: 100vh; background-size: cover; padding: 120px 0 60px;">
        <div class="container d-flex flex-column align-items-center position-relative" data-aos="zoom-out">
            <h2 class="text-white text-center">{{ getSetting('app_name') }}</h2>
            <p class="text-center text-white">Ajukan tugas akhir anda sekarang, explorasi ide-ide kreatif, dan bersama kita capai kesuksesan dalam perjalanan akademis yang luar biasa</p>
        </div>
    </section>

    <section id="tawaran-topik" style="padding: 60px 0 100px 0" class="rekomendasi-topik">
        <div class="container">
            <div class="text-center mb-5">
                <h5 class="font-size-24  m-0 fw-bold" style="color: var(--primary-color)">Tawaran Topik Tugas Akhir</h5>
                <p class="text-muted"><span>Temukan topik yang sesuai dengan bidang keahlian kamu</span></p>
            </div>            
            <div class="info" id="info">
                @forelse ($tawaran as $item)
                <div class="info-item d-flex">
                    <div class="row w-100">
                    <div class="col-lg-12">
                        <p class="m-0"><span class="badge rounded-pill bg-primary-subtle text-primary small mb-1">{{ $item->program_studi->nama }}</span></p>
                        <h6 class="m-0"><b>{{ $item->judul }}</b></h4>
                        <p class="m-0" style="font-size: 14px; text-align: justify">
                        <span class="short-description" >{{ Str::limit($item->deskripsi, 200) }}</span>
                        <span class="full-description d-none" >{{ $item->deskripsi }}</span>
                        @if(strlen($item->deskripsi) > 200)<a href="javascript:void(0);" class="read-more" onclick="toggleDescription(this)">Selengkapnya</a>@endif
                        </p>
                        <p class="text-muted small m-0 info-details">
                            <span class="dosen-info"><i class="bx bx-user me-1"></i>{{ $item->dosen->name }}</span>
                            <span class="kuota-group">
                                <span class="kuota-info"><i class="bx bx-group me-1"></i>{{ $item->ambilTawaran()->where('status', 'Disetujui')->count() }}/{{ $item->kuota }} Kuota</span>
                                <span class="diambil-oleh-info">| Diambil oleh {{ $item->ambilTawaran()->where('status', '!=', 'Ditolak')->count() }} Mahasiswa</span>
                            </span>
                        </p>
                    </div>
                    </div>
                </div>
                @empty
                <p class="text-center " style="color: #aeaeae">Tidak ada tawaran</p>
                @endforelse
            </div>
        </div>
        @if ($tawaran->count() > 4)
        <div class="d-flex justify-content-center" style="margin-top: 40px">
            <a href="{{ route('guest.rekomendasi-topik') }}" style="color: var(--primary-color)" class="small">Lihat Semua...</a>
        </div>
        @endif
    </section>

    <section id="judul-tugas-akhir" style="padding: 60px 0 100px 0" class="judul-tugas-akhir">
        <div class="container">
            <h5 class="font-size-24 text-center m-0 fw-bold mb-5" style="color: var(--primary-color)">Judul Tugas Akhir Yang Disetujui</h5>
            @forelse ($tugasAkhir as $item)
            <div class="info-item d-flex mb-3">
                <div>
                    <p class="m-0">
                        <span class="badge" style="background-color: #AFB0DA; color:var(--primary-color);">{{ $item->tipe == 'I' ? 'Individu' : 'Kelompok' }}</span>
                    </p>
                    <h6 class="m-0 font-size-14"><b>{{ $item->judul }}</b></h4>
                    <p class="m-0 small">{{ $item->mahasiswa->nama_mhs }}</p>
                    <p class="m-0 small">{{ $item->jenis_ta->nama_jenis }} - {{ $item->topik->nama_topik }}</p>
                    <p class="text-muted small m-0">
                        <span class="me-2">
                            @foreach ($item->bimbing_uji()->where('jenis', 'pembimbing')->orderBy('urut', 'asc')->get() as $dosen)
                                <i class="bx bx-user me-1"></i> {{ $dosen->dosen->name }}
                                @if (!$loop->last)
                                    /
                                @endif
                            @endforeach
                        </span>
                    </p>
                </div>
            </div>  
            @empty
                <tr>
                <p class="text-center " style="color: #aeaeae">Tidak ada tugas akhir</p>
                </tr>
            @endforelse
        </div>
        @if ($tugasAkhir->count() > 4)
        <div class="d-flex justify-content-center" style="margin-top: 40px">
            <a href="{{ route('guest.judul-tugas-akhir') }}" style="color: var(--primary-color)" class="small">Lihat Semua...</a>
        </div>
        @endif
    </section>

    <section id="jadwal" class="jadwal" style="padding: 60px 0 100px 0">
        <div class="container">
            <h5 class="font-size-24 text-center m-0 fw-bold mb-1">Jadwal Mahasiswa</h5>
            <ul class="nav nav-pills w-100 mb-2">
                <li class="flex-fill">
                    <a  class="nav-link text-center fw-bold {{ $activeTab === 'pra_seminar' ? 'active' : '' }}"   href="{{ url()->current() }}?active_tab=pra_seminar&tanggal={{ $tanggal }}"  style="color: var(--primary-color)">
                        Akan Seminar
                    </a>
                </li>
                <li class="flex-fill">
                    <a class="nav-link text-center fw-bold {{ $activeTab === 'pra_sidang' ? 'active' : '' }}" href="{{ url()->current() }}?active_tab=pra_sidang&tanggal={{ $tanggal }}" style="color: var(--primary-color)">
                        Akan Sidang
                    </a>
                </li>
            </ul>

            <ul class="nav nav-pills w-100 mb-3">
                @foreach ($tanggalTabs as $tabTanggal)
                    <li class="flex-fill">
                        <a class="nav-link text-center {{ $tabTanggal === $tanggal ? 'active' : '' }}" style="font-size: 14px; color: var(--primary-color)"  href="{{ url()->current() }}?active_tab={{ $activeTab }}&tanggal={{ $tabTanggal }}">
                            {{ $tabTanggal }}
                        </a>
                    </li>
                @endforeach
            </ul>

            @forelse ($jadwal as $key => $item)
                <div class="row p-1 mt-3 g-0 mb-3 align-items-center" style="max-width: 650px;">
                    <div class="col-md-2">
                        <img id="modal-image-{{ $key }}" src="{{ asset('storage/files/pemberkasan/poster.jpg') }}" alt="Poster" class="img-fluid" style="width: 120px; height: 150px; cursor: pointer;" data-bs-toggle="modal" data-bs-target="#imagePreviewModal-{{ $key }}">
                        <div class="modal fade" id="imagePreviewModal-{{ $key }}" tabindex="-1" aria-labelledby="imagePreviewLabel" aria-hidden="true" style="backdrop-filter: blur(5px); background-color: rgba(0, 0, 0, 0.5);">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-body p-0">
                                        <img id="preview-image-{{ $key }}" src="{{ asset('storage/files/pemberkasan/poster.jpg') }}" alt="Preview Poster" class="img-fluid preview-image">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-10">
                        <div class="ps-3">
                            <p class="m-0">11.00 - 11.00 WIB</p>
                            <h6 class="m-0"><b>Sistem Informasi Manajemen Persuratan</b></h6>
                            <p class="m-0">
                                <span class="badge me-2" style="background-color: #dfdfdf; color:var(--primary-color); letter-spacing: 1px">Individu</span> |
                                <span class="ms-2">Rancang Bangun - Penelitian</span>
                            </p>
                            <p class="m-0 fw-bold" style="font-size: 16px">Rikiansyah Aris Kurniawan</p>
                            <p class="text-muted small m-0" style="font-size: 14px">
                                Pembimbing: <span class="me-2">Dianni Yusuf, S.Kom., M.Kom</span> /
                                <span class="ms-2">Lutfi Hakim, S.Pd., M.T</span>
                            </p>
                            <p class="text-muted small m-0" style="font-size: 14px">
                                Penguji: <span class="me-2">Dianni Yusuf, S.Kom., M.Kom</span> /
                                <span class="ms-2">Lutfi Hakim, S.Pd., M.T</span>
                            </p>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-center " style="color: #aeaeae">Belum ada data</p>
            @endforelse

            @if($jadwal->count() > 4)
            <div class="text-center mt-5">
                <a href="#" style="color: var(--primary-color)" class="small">Lihat Semua...</a>
            </div>
            @endif
        </div>
    </section>

    <section id="mahasiswa" class="mahasiswa" style="padding: 60px 0 100px 0">
        <div class="container">
            <h5 class="font-size-24 text-center m-0 fw-bold mb-1">Mahasiswa</h5>
            <ul class="nav nav-pills w-100 mb-5">
                <li class="flex-fill">
                    <a class="nav-link {{ $tabs === 'seminar' ? 'active' : '' }} text-center fw-bold"  href="{{ url()->current() . '?' . http_build_query(array_merge(request()->query(), ['tabs' => 'seminar'])) }}" style="color: var(--primary-color)">
                        Sudah Seminar
                    </a>
                </li>
                <li class="flex-fill">
                    <a class="nav-link {{ $tabs === 'sidang' ? 'active' : '' }} text-center fw-bold"  href="{{ url()->current() . '?' . http_build_query(array_merge(request()->query(), ['tabs' => 'sidang'])) }}" style="color: var(--primary-color)">
                        Sudah Sidang
                    </a>
                </li>
            </ul>
            
            @foreach ($completed as $key => $item)
                <div class="row p-1 mt-3 g-0 mb-3 align-items-center" style="max-width: 650px;">
                    <div class="col-md-2">
                        <img id="modal-image-{{ $key }}" src="{{ asset('storage/files/pemberkasan/poster.jpg') }}" alt="Poster" class="img-fluid" style="width: 120px; height: 150px; cursor: pointer;" data-bs-toggle="modal" data-bs-target="#imagePreviewModal-{{ $key }}">
                        <div class="modal fade" id="imagePreviewModal-{{ $key }}" tabindex="-1" aria-labelledby="imagePreviewLabel" aria-hidden="true" style="backdrop-filter: blur(5px); background-color: rgba(0, 0, 0, 0.5);">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-body p-0">
                                        <img id="preview-image-{{ $key }}" src="{{ asset('storage/files/pemberkasan/poster.jpg') }}" alt="Preview Poster" class="img-fluid preview-image">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-10">
                        <div class="ps-3">
                            <p class="m-0">11.00 - 11.00 WIB</p>
                            <h6 class="m-0"><b>Sistem Informasi Manajemen Persuratan</b></h6>
                            <p class="m-0">
                                <span class="badge me-2" style="background-color: #dfdfdf; color:var(--primary-color); letter-spacing: 1px">Individu</span> |
                                <span class="ms-2">Rancang Bangun - Penelitian</span>
                            </p>
                            <p class="m-0 fw-bold" style="font-size: 16px">Rikiansyah Aris Kurniawan</p>
                            <p class="text-muted small m-0" style="font-size: 14px">
                                Pembimbing: <span class="me-2">Dianni Yusuf, S.Kom., M.Kom</span> /
                                <span class="ms-2">Lutfi Hakim, S.Pd., M.T</span>
                            </p>
                            <p class="text-muted small m-0" style="font-size: 14px">
                                Penguji: <span class="me-2">Dianni Yusuf, S.Kom., M.Kom</span> /
                                <span class="ms-2">Lutfi Hakim, S.Pd., M.T</span>
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach

            <div class="text-center mt-5">
                <a href="#" style="color: var(--primary-color)" class="small">Lihat Semua...</i></a>
            </div>
        </div>
    </section>

    <section id="grafik" class="grafik" style="padding: 60px 0 100px 0">
        <div class="container">
            <h5 class="font-size-24 text-center m-0 fw-bold mb-1">Statistik Tugas Akhir</h5>
            <div class="card mt-3">
                <div class="card-body">
                    <div id="column_chart" class="apex-charts" dir="ltr"></div>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('scripts')

<script>
    options = {
        chart: {
            height: 350,
            type: "bar",
            toolbar: {
                show: !1
            }
        },
        plotOptions: {
            bar: {
                horizontal: !1,
                columnWidth: "45%",
                endingShape: "rounded"
            }
        },
        dataLabels: {
            enabled: !1
        },
        stroke: {
            show: !0,
            width: 2,
            colors: ["transparent"]
        },
        series: [{
            name: "Net Profit",
            data: [46, 57, 59, 54, 62, 58, 64, 60, 66]
        }, {
            name: "Revenue",
            data: [74, 83, 102, 97, 86, 106, 93, 114, 94]
        }, {
            name: "Free Cash Flow",
            data: [37, 42, 38, 26, 47, 50, 54, 55, 43]
        }],
        colors: ["#45cb85", "#3b5de7", "#eeb902"],
        xaxis: {
            categories: ["Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct"]
        },
        yaxis: {
            title: {
                text: "$ (thousands)"
            }
        },
        grid: {
            borderColor: "#f1f1f1"
        },
        fill: {
            opacity: 1
        },
        tooltip: {
            y: {
                formatter: function (e) {
                    return "$ " + e + " thousands"
                }
            }
        }
    };
    (chart = new ApexCharts(document.querySelector("#column_chart"), options)).render();

</script>

@endsection