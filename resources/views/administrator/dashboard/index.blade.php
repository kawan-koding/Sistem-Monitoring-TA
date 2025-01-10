@extends('administrator.layout.main')

@section('content')

<style>
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

    .chevron-button {
        cursor: pointer;
    }

</style>

@if (session('switchRoles') == 'Admin')
    @include('administrator.dashboard.partials.admin')
@elseif (session('switchRoles') == 'Mahasiswa')
    @include('administrator.dashboard.partials.mahasiswa')
@elseif (session('switchRoles') == 'Dosen')
    @include('administrator.dashboard.partials.dosen')
@elseif (session('switchRoles') == 'Kaprodi')
    @include('administrator.dashboard.partials.kaprodi')
@endif

@if(session('switchRoles') == 'Admin')
    
@endif

<div class="card shadow-sm mb-3">
    <div class="d-flex border-bottom">
        <div class="px-4 d-flex align-items-center border chevron-button" data-direction="left"><i class="fa fa-chevron-left"></i></div>
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
        <div class="px-4 d-flex align-items-center border chevron-button" data-direction="right"><i class="fa fa-chevron-right"></i></div>
    </div>
    <div class="card-body">
        <div class="col-md-10 col-sm-12 col-12 mb-3 mx-auto mt-2 mb-4">
            <div class="row justify-content-between align-items-center">
                @if(session('switchRoles') == 'Dosen')
                    <div class="col-md-6 col-sm-6">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Search..." autocomplete="off" data-role="schedule-search">
                            <span class="input-group-text"><i class="fa fa-search"></i></span>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6 ">
                        <form class="d-inline">
                            <select name="filter" class="form-select d-inline-block w-auto">
                                <option value="seminar">Seminar Proposal</option>
                                <option value="sidang">Sidang Akhir</option>
                            </select>
                        </form>
                        <div class="btn-group" role="group">
                            <button id="btnGroupVerticalDrop1" type="button" class="btn btn-primary dropdown-toggle" style="max-width: 150px;" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-file-excel me-2"></i> Export <i class="mdi mdi-chevron-down"></i>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="btnGroupVerticalDrop1">
                                <a class="dropdown-item" target="_blank" href="{{ route('apps.dashboard.export-jadwal') }}">Pembimbing</a>
                                <a class="dropdown-item" target="_blank" href="{{ route('apps.dashboard.export-jadwal') }}">Penguji</a>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="col-md-8 col-sm-10 mx-auto">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Search..." autocomplete="off" data-role="schedule-search">
                            <span class="input-group-text"><i class="fa fa-search"></i></span>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        
        {{-- <div class="col-md-5 col-sm-10 col-12 mb-3 mx-auto mt-2 mb-4">
            <div class="row">
                <div class="col-12 d-flex gap-3">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search..." autocomplete="off" data-role="schedule-search">
                        <span class="input-group-text"><i class="fa fa-search"></i></span>
                    </div>
                </div>
            </div>
        </div> --}}
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


@endsection
