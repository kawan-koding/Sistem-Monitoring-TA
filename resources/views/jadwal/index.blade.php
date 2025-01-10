@extends('layout.app')

@section('content')
<section id="hero-fullscreen" class="hero-fullscreen d-flex align-items-center" style="background: url('{{ asset('storage/images/settings/' . getSetting('app_bg')) }}') center center; width: 100%; min-height: 100vh; background-size: cover; padding: 120px 0 60px;"  >
  <div class="container d-flex flex-column align-items-center position-relative" data-aos="zoom-out">
      <h2 class="text-white text-center">{{ getSetting('app_name') }}</h2>
  </div>
</section>

<section id="jadwal" class="jadwal" style="padding: 60px 0 100px 0">
    <div class="container">
        <h5 class="font-size-24 text-center m-0 fw-bold mb-1">Jadwal Mahasiswa</h5>
        <ul class="nav nav-pills w-100 mb-2">
            <li class="flex-fill">
                <a class="nav-link text-center fw-bold" data-tab="pra_seminar" href="javascript:void(0);" onclick="changeTab('pra_seminar', this)">Akan Seminar</a>
            </li>
            <li class="flex-fill">
                <a class="nav-link text-center fw-bold" data-tab="pra_sidang" href="javascript:void(0);" onclick="changeTab('pra_sidang', this)">Akan Sidang</a>
            </li>
        </ul> 
        <div class="d-flex justify-content-center align-items-center mb-3">
            <div class="search" style="max-width: 300px; width: 100%;">
                <form onsubmit="searchJadwal(event)" style="width: 100%;">
                    <input class="form-control" type="text" name="search" id="search" placeholder="Cari..." />
                </form>
            </div>
        </div>
        <div id="jadwal-all-list" class="row"></div>
    </div>
</section>


<section id="mahasiswa" class="mahasiswa" style="padding: 60px 0 100px 0">
  <div class="container">
      <h5 class="font-size-24 text-center m-0 fw-bold mb-1">Daftar Mahasiswa</h5>
      <ul class="nav nav-pills w-100 mb-5">
          <li class="flex-fill">
              <a class="nav-link  text-center fw-bold" data-toggle="seminar" href="javascript:void(0);" onclick="changeData('seminar', this)" style="color: var(--primary-color)">Sudah Seminar</a>
          </li>
          <li class="flex-fill">
              <a class="nav-link  text-center fw-bold" data-toggle="sidang"  href="javascript:void(0);" onclick="changeData('sidang', this)" style="color: var(--primary-color)">Sudah Sidang</a>
          </li>
      </ul>
      <div id="mahasiswa-all-list" class="row"></div>
  </div>
</section>
@endsection

@section('scripts')
<script>

    var tabJadwal = 'pra_seminar';

    const searchJadwal = (event) => {
        event.preventDefault();
        const searchText = document.getElementById('search').value.toLowerCase();
        const rows = document.querySelectorAll('#jadwal-all-list table tbody tr');
        rows.forEach(row => {
            const cells = row.getElementsByTagName('td');
            let rowText = '';
            for (let i = 0; i < cells.length; i++) {
                rowText += cells[i].textContent.toLowerCase() + ' ';
            }
            if (rowText.includes(searchText)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    };
    document.getElementById('search').addEventListener('input', searchJadwal);

    const searchDaftar = (event) => {
        event.preventDefault();
        cons searchText = document.getElementById('search').value.toLowerCase();    
    }

    const fetchJadwalData = async (tab) => {
        tabJadwal = tab;
        document.querySelectorAll('.nav-link').forEach(link => link.classList.remove('active'));

        const tabElement = document.querySelector(`.nav-link[data-tab="${tab}"]`);
        if (tabElement) {
            tabElement.classList.add('active');
        }
        const data = await getJadwalData(tab);
        renderJadwalTable(data);
    };

    const getJadwalData = async (tabJadwal) => {
        try {
            const res = await fetch(`${BASE_URL}/get-all-jadwal?active_tab=${tabJadwal}`);
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
        var renderData = $('#jadwal-all-list');
        var render = '';
        if (data.data.length == 0) {
            render += `
                <div class="d-flex align-items-center justify-content-center py-5">
                    <div class="text-center py-5">
                        <img src="${ASSET_URL}assets/images/no-data.png" height="350" alt="">
                        <p class="text-muted m-0">Tidak ada jadwal yang ditemukan.</p>
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
                            <p class="fw-bold  m-0">Pembimbing</p>
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

    const changeTab = async (tabJadwal, tabElement) => {
        Swal.fire({
            title: 'Loading...',
            html: 'Memuat data...',
            timer: 2000,
            didOpen: () => {
                Swal.showLoading();
            }
        });
        const tabs = document.querySelectorAll('.nav-link');
        tabs.forEach(tab => tab.classList.remove('active'));
        tabElement.classList.add('active');
        const data = await fetchJadwalData(tabJadwal);
        Swal.close();   
        renderJadwalTable(data);
    };


    window.onload = async () => {
        const data = await fetchJadwalData('pra_seminar');
        renderJadwalTable(data);
        const tabElement = document.querySelector(`.nav-link[data-tab="pra_seminar"]`);
        if (tabElement) {
            await changeTab(tabElement, 'pra_seminar');
        }
    };

</script>

<script>
    var tabMahasiswa = 'seminar';

    const fetchMahasiswaData = async (tab) => {
        tabMahasiswa = tab;
        document.querySelectorAll('.nav-link').forEach(link => link.classList.remove('active'));

        const tabElement = document.querySelector(`.nav-link[data-toggle="${tab}"]`);
        if (tabElement) {
            tabElement.classList.add('active');
        }
        const data = await getMahasiswaData(tab);
        renderMahasiswaTable(data);
    };

    const getMahasiswaData = async (tabMahasiswa) => {
        try {
            const res = await fetch(`${BASE_URL}/get-daftar-mahasiswa?active_tab=${tabMahasiswa}`);
            if (!res.ok) {
                throw new Error('Gagal mengambil data');
            }
            const data = await res.json();
            return data;
        } catch (error) {
            return null;
        }
    };

    const renderMahasiswaTable = (data = null) => {
        var renderData = $('#mahasiswa-all-list');
        var render = '';
        if (data.data.length == 0) {
            render += `
                <div class="d-flex align-items-center justify-content-center py-5">
                    <div class="text-center py-5">
                        <img src="${ASSET_URL}assets/images/no-data.png" height="350" alt="No Data">
                        <p class="text-muted m-0">Tidak ada mahasiswa yang ditemukan.</p>
                    </div>
                </div>
            `;
        } else {
            render += `
                <div class="table-container">
                <table class="table zero-configuration" style="font-size: 14px!important">
                    <thead>
                        <th style="width: 20%; white-space: nowrap;">Nama</th>
                        <th style="width: 40%; white-space: nowrap;">Program Studi</th>
                        <th style="width: 40%; white-space: nowrap;">Judul</th>
                    </thead>
                    <tbody>
            `;

            for (let i = 0; i < data.data.length; i++) {
                var item = data.data[i];
                render += `
                    <tr>
                        <td>
                            <p class="m-0">${item.mahasiswa.nama_mhs}</p>
                            <p class="m-0">${item.mahasiswa.nim}</p>
                        </td>
                        <td>
                            <p class="m-0">${item.mahasiswa.program_studi.display ?? '-'}</p>
                        </td>
                        <td>${item.judul ?? '-'}</td>
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

    const changeData = async (tabMahasiswa, tabElement) => {
        Swal.fire({
            title: 'Loading...',
            html: 'Memuat data...',
            timer: 2000,
            didOpen: () => {
                Swal.showLoading();
            }
        });
        const tabs = document.querySelectorAll('.nav-link');
        tabs.forEach(tab => tab.classList.remove('active'));
        tabElement.classList.add('active');
        const data = await fetchMahasiswaData(tabMahasiswa);
        Swal.close();   
        renderMahasiswaTable(data);
    };

    window.onload = async () => {
        const mahasiswaData = await fetchMahasiswaData('seminar');
        renderMahasiswaTable(mahasiswaData);
        const mahasiswaTabElement = document.querySelector(`.nav-link[data-toggle="seminar"]`);
        if (mahasiswaTabElement) {
            await changeData('seminar', mahasiswaTabElement);
        }
    };
</script>

@endsection