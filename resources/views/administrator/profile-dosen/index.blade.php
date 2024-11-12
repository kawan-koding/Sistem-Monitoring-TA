@extends('administrator.layout.main')

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-g-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="datatable">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th>Nama Dosen</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $item)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>
                                    <p class="m-0"><span class="badge rounded-pill bg-primary-subtle text-primary small">{{ $item->programStudi->nama }}</span></p>
                                    <p class="fw-bold font-size-14 m-0">{{ $item->name }}</p>    
                                    <p class="m-0 small"><strong>NIDN.</strong> {{ $item->nidn }} | <strong>NIP/NIK/NIPPPK.</strong> {{ $item->nip }}</p>    
                                    <p class="m-0 small"><strong>Email.</strong> {{ $item->email }} | <strong>Nomor.</strong> {{ $item->telp }}</p>
                                    <p class="m-0 small"><strong>Bidang Keahlian :</strong> {{ $item->bidang_keahlian }}</p>    
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection