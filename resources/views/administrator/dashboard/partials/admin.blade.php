{{-- <style>
    .card {
        position: relative;
        overflow: hidden;
    }

    .card-icon {
        position: absolute;
        top: 0;
        right: -2%;
        transform: translateY(-50%);
        font-size: 5rem;
        opacity: 0.3;
        transform: rotate(25deg);
    }

    .date-area {
        width: 100%;
        overflow: hidden;
        display: flex;
        justify-content: start;
    }

    .date-area-scroll {
        display: flex;
        cursor: grab;
    }

    .date-item {
        display: block;
        padding: 1.2rem 3.5rem;
        user-select: none;
        white-space: nowrap;
        text-align: center;
        font-size: 0.8rem;
        line-height: 15 px;
    }

    /* shadow-bottom inner if actived */
    .date-item.active {
        color: #2d3cc7 !important;
        font-weight: bold;
        box-shadow: 0px 5px 10px #13209660 inset;
    }

    #schedule-content::-webkit-scrollbar {
        width: 5px;
    }

    #schedule-content::-webkit-scrollbar-track {
        background: #f1f1f1;
    }

    #schedule-content::-webkit-scrollbar-thumb {
        background: #c2c1c1;
    }

    #schedule-content::-webkit-scrollbar-thumb:hover {
        background: #a0a0a0;
    }
</style> --}}

<div class="row">
    <div class="col-md-4 col-sm-6 col-12">
        <div class="card shadow-sm border-primary" style="border-width: 0px 0px 0px 3px;">
            <div class="card-icon">
                <i class="fa fa-user"></i>
            </div>
            <div class="card-body">
                <h3 class="mb-2">{{ $dosenCount }} </h3>
                <p class="mb-0">Total Dosen</p>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-sm-6 col-12">
        <div class="card shadow-sm border-primary" style="border-width: 0px 0px 0px 3px;">
            <div class="card-icon">
                <i class="fa fa-users"></i>
            </div>
            <div class="card-body">
                <h3 class="mb-2">{{ $mhsCount }} </h3>
                <p class="mb-0">Total Mahasiswa</p>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-sm-6 col-12">
        <div class="card shadow-sm border-primary" style="border-width: 0px 0px 0px 3px;">
            <div class="card-icon">
                <i class="fa fa-book-open"></i>
            </div>
            <div class="card-body">
                <h3 class="mb-2">{{ $taCount }} </h3>
                <p class="mb-0">Total Tugas Akhir</p>
            </div>
        </div>
    </div>

    {{-- student information --}}
    <div class="col-md-3 col-sm-6 col-12">
        <div class="card shadow-sm border-primary text-white"
            style="border-width: 0px 0px 0px 3px;background: linear-gradient(to right, #3789f5, #222faa);">
            <div class="card-icon">
                <i class="bx bx-user-pin"></i>
            </div>
            <div class="card-body">
                <h3 class="mb-2">{{ $mhsBelumMengajukanCount }} </h3>
                <p class="mb-0">Total Mahasiswa Belum Mengajukan</p>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6 col-12">
        <div class="card shadow-sm border-primary text-white"
        style="border-width: 0px 0px 0px 3px;background: linear-gradient(to right, #3789f5, #222faa);">
        <div class="card-icon">
            <i class="bx bx-user-check"></i>
        </div>
            <div class="card-body">
                <h3 class="mb-2">{{ $mhsBelumSeminarCount }} </h3>
                <p class="mb-0">Total Mahasiswa Belum Seminar</p>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6 col-12">
        <div class="card shadow-sm border-primary text-white"
            style="border-width: 0px 0px 0px 3px;background: linear-gradient(to right, #3789f5, #222faa);">
            <div class="card-icon">
                <i class="bx bx-user-pin"></i>
            </div>
            <div class="card-body">
                <h3 class="mb-2">{{ $mhsSudahSeminarCount }} </h3>
                <p class="mb-0">Total Mahasiswa Sudah Seminar</p>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6 col-12">
        <div class="card shadow-sm border-primary text-white"
            style="border-width: 0px 0px 0px 3px;background: linear-gradient(to right, #3789f5, #222faa);">
            <div class="card-icon">
                <i class="bx bx-user-check"></i>
            </div>
            <div class="card-body">
                <h3 class="mb-2">{{ $mhsSudahPemberkasanSeminarCount }} </h3>
                <p class="mb-0">Total Mahasiswa Sudah Pemberkasan Seminar</p>
            </div>
        </div>
    </div>

    <div class="col-md-3 col-sm-6 col-12">
        <div class="card shadow-sm border-primary text-white"
            style="border-width: 0px 0px 0px 3px;background: linear-gradient(to right, #3789f5, #222faa);">
            <div class="card-icon">
                <i class="bx bx-user-check"></i>
            </div>
            <div class="card-body">
                <h3 class="mb-2">{{ $mhsDaftarSidangCount }} </h3>
                <p class="mb-0">Total Mahasiswa Daftar Sidang</p>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6 col-12">
        <div class="card shadow-sm border-primary text-white"
            style="border-width: 0px 0px 0px 3px;background: linear-gradient(to right, #3789f5, #222faa);">
            <div class="card-icon">
                <i class="bx bx-user-pin"></i>
            </div>
            <div class="card-body">
                <h3 class="mb-2">{{ $mhsBelumSidangCount }} </h3>
                <p class="mb-0">Total Mahasiswa Belum Sidang</p>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6 col-12">
        <div class="card shadow-sm border-primary text-white"
            style="border-width: 0px 0px 0px 3px;background: linear-gradient(to right, #3789f5, #222faa);">
            <div class="card-icon">
                <i class="bx bx-user-check"></i>
            </div>
            <div class="card-body">
                <h3 class="mb-2">{{ $mhsSudahSidangCount }} </h3>
                <p class="mb-0">Total Mahasiswa Sudah Sidang</p>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6 col-12">
        <div class="card shadow-sm border-primary text-white"
            style="border-width: 0px 0px 0px 3px;background: linear-gradient(to right, #3789f5, #222faa);">
            <div class="card-icon">
                <i class="bx bx-user-pin"></i>
            </div>
            <div class="card-body">
                <h3 class="mb-2">{{ $mhsSudahPemberkasanSidangCount }} </h3>
                <p class="mb-0">Total Mahasiswa Sudah Pemberkasan Sidang</p>
            </div>
        </div>
    </div>

</div>

<div class="row">
    <div class="col-md-8 col-sm-6 col-12">
        <div class="card shadow-sm mb-3" style="height: calc(100% - 1.5rem)">
            <div class="card-body">
                <h6 class="fw-bold">Statistik Kelulusan</h6>
                <div id="graduatedGraph" style="height: 350px"></div>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-sm-6 col-12">
        <div class="card shadow-sm mb-3" style="height: calc(100% - 1.5rem)">
            <div class="card-body">
                <h6 class="fw-bold">Statistik Mahasiswa</h6>
                <div id="studentGraph" style="height: 350px"></div>
            </div>
        </div>
    </div>
</div>