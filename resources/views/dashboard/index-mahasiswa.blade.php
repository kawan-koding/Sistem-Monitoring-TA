@extends('layout.admin-main')
@section('content')

{{-- <style> 
    .custom-card { 
        border: 2px solid #007bff; 
        border-radius: 15px; 
        padding: 20px; 
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); 
        text-align: center; 
    } 
    .custom-card-reject { 
        border: 2px solid #FF0000; 
        border-radius: 15px; 
        padding: 20px; 
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); 
        text-align: center; 
    } 
    .custom-card-belum { 
        border: 2px solid #330b0b; 
        border-radius: 15px; 
        padding: 20px; 
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); 
        text-align: center; 
    } 
    .custom-card-draft { 
        border: 2px solid #7D7C7C; 
        border-radius: 15px; 
        padding: 20px; 
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); 
        text-align: center; 
    } 
    .status-text { 
        font-size: 24px; 
        font-weight: bold; 
        margin-bottom: 20px; 
        color: #007bff; 
    } 
    .status-text-draft { 
        font-size: 24px; 
        font-weight: bold; 
        margin-bottom: 20px; 
        color: #7D7C7C; 
    } 
    .status-text-reject { 
        font-size: 24px; 
        font-weight: bold; 
        margin-bottom: 20px; 
        color: #FF0000; 
    } 
    .status-text-belum { 
        font-size: 24px; 
        font-weight: bold; 
        margin-bottom: 20px; 
        color: #330b0b; 
    } 
    .icon { 
        font-size: 50px; 
        color: #007bff; 
    } 
    .icon-draft { 
        font-size: 50px; 
        color: #7D7C7C; 
    } 
    .icon-reject { 
        font-size: 50px; 
        color: #FF0000; 
    } 
    .icon-belum { 
        font-size: 50px; 
        color: #330b0b; 
    } 
</style>

<div class="row">
    <div class="col-xl-6">
        @if($statusTa == 'draft')
        <div class="card custom-card-draft"> 
            <div class="card-body"> 
                <h5 class="card-title">Status Proposal</h5> 
                <p class="status-text-draft">Draft</p> 
                <i class="fas fa-box icon-draft"></i> 
            </div> 
        </div>
        @endif
        @if($statusTa == 'acc')
        <div class="card custom-card"> 
            <div class="card-body"> 
                <h5 class="card-title">Status Proposal</h5> 
                <p class="status-text">Disetujui</p> 
                <i class="fas fa-check-circle icon"></i> 
            </div> 
        </div>
        @endif
        @if($statusTa == 'reject')
        <div class="card custom-card-reject"> 
            <div class="card-body"> 
                <h5 class="card-title">Status Proposal</h5> 
                <p class="status-text-reject">Ditolak</p> 
                <i class="fas fa-times icon-reject"></i> 
            </div> 
        </div>
        @endif
        @if($statusTa == 'belum')
        <div class="card custom-card-belum"> 
            <div class="card-body"> 
                <h5 class="card-title">Status Proposal</h5> 
                <p class="status-text-belum">Belum Memiliki</p> 
                <i class="fas fa-times icon-belum"></i> 
            </div> 
        </div>
        @endif
    </div>


    <style> .jadual-card { border: 2px solid #333; border-radius: 10px; padding: 20px; margin-bottom: 20px; text-align: center; } .icon-jadwal { font-size: 50px; color: #333; margin-bottom: 15px; } .event-title { font-size: 24px; font-weight: bold; color: #333; } .event-time { font-size: 16px; color: #333; } </style>
    <div class="col-xl-6">
        <div class="card jadual-card"> 
            <div class="card-body"> 
                <i class="far fa-calendar-check icon-jadwal"></i> 
                <h5 class="card-title event-title">Jadwal Seminar Proposal</h5> 
                @if ($jam_mulai == 0)
                <p class="event-time">Belum terjadwalkan</p>
                @else
                <p class="event-time">{{$jadwalSeminar}} <br> {{date('H:i',strtotime($jam_mulai)) . '-'. date("H:i",strtotime($jam_selesai))}}</p>
                @endif
            </div> 
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h4>List Dosen</h4>
                <hr>
                <div class="table-responsive">
                    <table class="table table-striped" id="datatable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>NIDN</th>
                                <th>Nama</th>
                                <th>Rumpun Ilmu</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data_dosen as $item) 
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$item->nidn}}</td>
                                <td>{{$item->name}}</td>
                                <td>
                                    <ul>
                                        @foreach ($item->rumpun_ilmu as $i)
                                        <li>{{$i->nama}}</li>
                                        @endforeach
                                    </ul>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div> --}}

@endsection
