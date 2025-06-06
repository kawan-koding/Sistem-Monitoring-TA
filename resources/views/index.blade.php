@extends('layout.app')
@section('content')

    <section id="hero-fullscreen" class="hero-fullscreen d-flex align-items-center" style="background: url('{{ asset('storage/images/settings/' . getSetting('app_bg')) }}') center center; width: 100%; min-height: 100vh; background-size: cover; padding: 120px 0 60px;">
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
                    <a class="nav-link nav-active text-center fw-bold" data-tab="pra_seminar" href="javascript:void(0);" onclick="changeTab('pra_seminar', this)">Akan Seminar</a>
                </li>
                <li class="flex-fill">
                    <a class="nav-link nav-active text-center fw-bold" data-tab="pra_sidang" href="javascript:void(0);" onclick="changeTab('pra_sidang', this)">Akan Sidang</a>
                </li>
            </ul>
            <div id="jadwal-list" class="row"></div>
        </div>
    </section>

@endsection

@section('scripts')
<script>
    var activeTab = 'pra_seminar';
    const fetchJadwalData = async (tab) => {
        activeTab = tab;
        document.querySelectorAll('.nav-active').forEach(link => link.classList.remove('active'));

        const tabElement = document.querySelector(`.nav-active[data-tab="${tab}"]`);
        if (tabElement) {
            tabElement.classList.add('active');
        }
        const data = await getJadwalData(tab);
        renderJadwalTable(data);
    };

    const getJadwalData = async (activeTab) => {
        try {
            const res = await fetch(`${BASE_URL}/get-jadwal?active_tab=${activeTab}`);
            if (!res.ok) {
                throw new Error('Gagal mengambil data');
            }
            const data = await res.json();
            return data;
        } catch (error) {
            return null;
        }
    };

    const renderJadwalTable = (data = null) => {
        var renderData = $('#jadwal-list');
        var render = '';
        if (data.data.length == 0) {
            render += `
                <div class="d-flex align-items-center justify-content-center py-5">
                    <div class="text-center py-5">
                        <img src="${ASSET_URL}assets/images/no-data.png" height="350" alt="">
                        <p class="text-muted m-0">Tidak ada jadwal hari ini yang ditemukan.</p>
                    </div>
                </div>
            `;
        } else {
            render += `
                <div class="table-container">
                <table class="table zero-configuration" style="font-size: 14px!important">
                    <thead>
                        <th style="width: 10%; white-space: nowrap;">Poster</th>
                        <th style="width: 20%; white-space: nowrap;">Nama</th>
                        <th style="width: 30%; white-space: nowrap;">Judul</th>
                        <th style="width: 30%; white-space: nowrap;">Dosen</th>
                        <th style="width: 10%;white-space: nowrap;">Waktu dan Tempat</th>
                    </thead>
                    <tbody>
            `;

            for (let i = 0; i < data.data.length; i++) {
                var item = data.data[i];

                render += `
                    <tr>
                        <td>
                            <img id="modal-image-${i}" src="${item.poster ? item.poster : 'https://ui-avatars.com/api/?background=random&name=' + encodeURIComponent(item.tugas_akhir.mahasiswa.nama_mhs)}" alt="Poster" class="img-fluid" style="max-width: 100px; max-height: 120px; cursor: pointer; object-fit: cover; border-radius: 5px; border: 1px solid #ccc;" data-bs-toggle="modal" data-bs-target="#imagePreviewModal-${i}">
                            <div class="modal fade" id="imagePreviewModal-${i}" tabindex="-1" aria-labelledby="imagePreviewLabel" aria-hidden="true" style="backdrop-filter: blur(5px); background-color: rgba(0, 0, 0, 0.5);">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-body p-0">
                                            <img id="preview-image-${i}" src="${item.poster ? item.poster : 'https://ui-avatars.com/api/?background=random&name=' + encodeURIComponent(item.tugas_akhir.mahasiswa.nama_mhs)}" alt="Preview Poster" class="img-fluid preview-image" style="border-radius: 5px; border: 1px solid #ccc;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="">
                            <span class="badge badge-soft-primary" style="color: #6c757d">${item.tugas_akhir.mahasiswa.program_studi.display}</span>
                            <span class="badge badge-soft-secondary" style="color: #3b5de7">${item.tugas_akhir.tipe == "I" ? "Individu" : "Kelompok"}</span>
                            <p class="m-0 p-0">${item.tugas_akhir.mahasiswa.nama_mhs}</p>
                            <p class="m-0 p-0">${item.tugas_akhir.mahasiswa.nim}</p>
                            </td>
                        <td class="">${item.tugas_akhir.judul ?? '-'}</td>
                        <td>
                            <p class="fw-bold  m-0">Pembimbing</p>
                            <ol class="m-0">
                                <li class="">${item.pembimbing_1 ?? '-'}</li>
                                <li class="">${item.pembimbing_2 ?? '-'}</li>
                            </ol>
                            <p class="fw-bold  m-0">Penguji</p>
                            <ol class="m-0">
                                <li class="">${item.penguji_1 ?? '-'}</li>
                                <li class="">${item.penguji_2 ?? '-'}</li>
                            </ol>
                        </td>
                        <td>
                            <strong class="m-0">${item.ruangan?.nama_ruangan ?? '-'}</strong>
                            <p class="m-0">${item.tanggal ?? '-'}</p>
                            <p class="m-0">${item.jam ?? '-'}</p>
                        </td>
                    </tr>
                `;
            }

            render += `
                    </tbody>
                </table>
                </div>
            `;
        }

        renderData.html(render);
    };

    const changeTab = async (activeTab, tabElement) => {
        Swal.fire({
            title: 'Loading...',
            html: 'Memuat data...',
            timer: 2000,
            didOpen: () => {
                Swal.showLoading();
            }
        });
        const tabs = document.querySelectorAll('.nav-active');
        tabs.forEach(tab => tab.classList.remove('active'));
        tabElement.classList.add('active');
        const data = await fetchJadwalData(activeTab);
        Swal.close();
        renderJadwalTable(data);
    };

    window.onload = async () => {
        const data = await fetchJadwalData('pra_seminar');
        renderJadwalTable(data);
        const tabElement = document.querySelector(`.nav-active[data-tab="pra_seminar"]`);
        if (tabElement) {
            await changeTab(tabElement, 'pra_seminar');
        }
    };

</script>
@endsection
