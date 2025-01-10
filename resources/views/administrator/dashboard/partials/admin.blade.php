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
                <h3 class="mb-2">{{ $mhsBelumSeminarCount }} </h3>
                <p class="mb-0">Total Mahasiswa Belum Seminar</p>
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
                <h3 class="mb-2">{{ $mhsSudahSeminarCount }} </h3>
                <p class="mb-0">Total Mahasiswa Sudah Seminar</p>
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
{{-- 
<div class="card shadow-sm mb-3">
    <div class="d-flex border-bottom">
        <div class="px-4 d-flex align-items-center border"><i class="fa fa-chevron-left"></i></div>
        <div class="date-area" data-role="resizable-container">
            <div class="date-area-scroll" data-role="resizable-item">
                @for ($year = 2024; $year <= 2025; $year++)
                    @for ($month = 1; $month <= 12; $month++)
                        @for ($i = 1; $i <= date('t', mktime(0, 0, 0, $month, 1, $year)); $i++)
                            <div class="date-item {{ date('d-m-Y', mktime(0, 0, 0, $month, $i, $year)) == date('d-m-Y') ? 'active' : '' }}"
                                data-value="{{ date('Y-m-d', mktime(0, 0, 0, $month, $i, $year)) }}">
                                <h3 class="m-0">{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}</h3>
                                <span
                                    class="text-muted small">{{ date('M Y', mktime(0, 0, 0, $month, $i, $year)) }}</span>
                            </div>
                        @endfor
                    @endfor
                @endfor
            </div>
        </div>
        <div class="px-4 d-flex align-items-center border"><i class="fa fa-chevron-right"></i></div>
    </div>
    <div class="card-body">
        <div class="col-md-5 col-sm-10 col-12 mb-3 mx-auto mt-2 mb-4">
            <div class="row">
                <div class="col-12 d-flex gap-3">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search..." autocomplete="off" data-role="schedule-search">
                        <span class="input-group-text"><i class="fa fa-search"></i></span>
                    </div>
                </div>
            </div>
        </div>
        <div id="schedule-content" style="min-height: 400px;max-height: 75vh;overflow-y: auto">
            <div class="d-flex align-items-center justify-content-center py-5">
                <div class="text-center py-5">
                    <img src="{{ asset('assets/images/no-data.png') }}" height="350" alt="">
                    <p class="text-muted m-0">Tidak ada jadwal yang ditemukan.</p>
                </div>
            </div>
        </div>
    </div>
</div>
 --}}
