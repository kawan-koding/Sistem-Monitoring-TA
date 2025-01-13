
<section id="mahasiswa" class="mahasiswa" style="padding: 60px 0 100px 0">
    <div class="container">
        <h5 class="font-size-24 text-center m-0 fw-bold mb-1">Daftar Mahasiswa</h5>
        <ul class="nav nav-pills w-100 mb-5">
            <li class="flex-fill">
                <a class="nav-link link-daftar text-center fw-bold" data-toggle="seminar" href="javascript:void(0);" onclick="changeMahasiswaTab('seminar', this)">Sudah Seminar</a>
            </li>
            <li class="flex-fill">
                <a class="nav-link link-daftar text-center fw-bold" data-toggle="sidang" href="javascript:void(0);" onclick="changeMahasiswaTab('sidang', this)">Sudah Sidang</a>
            </li>
        </ul>
        <div class="d-flex justify-content-center align-items-center mb-3">
            <div class="search" style="max-width: 300px; width: 100%;">
                <form onsubmit="searchMahasiswa(event)" style="width: 100%;">
                    <input class="form-control" type="text" name="search" id="search-mahasiswa" placeholder="Cari..." />
                </form>
            </div>
        </div>
        <div id="mahasiswa-all-list" class="row"></div>
    </div>
  </section>

@section('scripts')
<script>
    let mahasiswaTab = 'seminar';

    const searchMahasiswa = (event) => {
        event.preventDefault();
        const searchText = document.getElementById('search-mahasiswa').value.toLowerCase();
        const rows = document.querySelectorAll('#mahasiswa-all-list table tbody tr');
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
    document.getElementById('search-mahasiswa').addEventListener('input', searchMahasiswa);

    const fetchMahasiswaData = async (tab) => {
        mahasiswaTab = tab;
        document.querySelectorAll('.link-daftar').forEach(link => link.classList.remove('active'));
        const tabElement = document.querySelector(`.link-daftar[data-toggle="${tab}"]`);
        if (tabElement) {
            tabElement.classList.add('active');
        }
        const data = await getMahasiswaData(tab);
        renderMahasiswaTable(data);
    };

    const getMahasiswaData = async (tab) => {
        try {
            const res = await fetch(`${BASE_URL}/get-daftar-mahasiswa?active_tab=${tab}`);
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
                        <img src="${ASSET_URL}assets/images/no-data.png" height="350" alt="">
                        <p class="text-muted m-0">Tidak ada data mahasiswa yang ditemukan.</p>
                    </div>
                </div>
            `;
        } else {
            render += `
                <div class="table-container">
                    <table class="table zero-configuration" style="font-size: 14px!important">
                        <thead>
                            <th style="width: 20%;">Nama</th>
                            <th style="width: 30%;">Program Studi</th>
                            <th style="width: 30%;">Judul</th>
                            <th style="width: 20%;">Status</th>
                        </thead>
                        <tbody>
            `;
            for (let i = 0; i < data.data.length; i++) {
                const item = data.data[i];
                render += `
                    <tr>
                        <td>${item.nama}</td>
                        <td>${item.program_studi}</td>
                        <td>${item.judul ?? '-'}</td>
                        <td>${item.status}</td>
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

    const changeMahasiswaTab = async (tab, tabElement) => {
        Swal.fire({
            title: 'Loading...',
            html: 'Memuat data...',
            timer: 2000,
            didOpen: () => {
                Swal.showLoading();
            }
        });
        const tabs = document.querySelectorAll('.link-daftar');
        tabs.forEach(tab => tab.classList.remove('active'));
        tabElement.classList.add('active');
        const data = await fetchMahasiswaData(tab);
        Swal.close();
        renderMahasiswaTable(data);
    };

    window.onload = async () => {
        const data = await fetchMahasiswaData('seminar');
        renderMahasiswaTable(data);
    };
</script>   
@endsection