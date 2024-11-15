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
                                    <div class="d-flex align-items-start">
                                        <div class="me-3">
                                            <a href="#" data-bs-toggle="modal" data-bs-target="#imageModal-{{ $item->id }}">
                                                <img src="{{ asset('storage/images/users/' . ($item->user->image ?? 'default.png')) }}" alt="Profile" class="rounded-circle" style="width: 80px; height: 80px; cursor: pointer;">
                                            </a>
                                        </div>  
                                        <div class="modal fade" id="imageModal-{{ $item->id }}" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="imageModalLabel">{{ $item->name }}</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body text-center">
                                                        <img src="{{ asset('storage/images/users/' . ($item->user->image ?? 'default.png')) }}" alt="Profile" class="img-fluid">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            <p class="m-0 small"><span class="badge rounded-pill bg-primary-subtle text-primary small">{{ $item->programStudi->nama }}</span></p>
                                            <p class="fw-bold small font-size-14 m-0">{{ $item->name }}</p>    
                                            <p class="m-0 small"><strong>NIDN.</strong> {{ $item->nidn }} | <strong>NIP/NIK/NIPPPK.</strong> {{ $item->nip }}</p>    
                                            <p class="m-0 small"><strong>Email.</strong> {{ $item->email }} | <strong>Nomor.</strong> {{ $item->telp }}</p>
                                            <p class="m-0 small"><strong>Bidang Keahlian :</strong> {{ $item->bidang_keahlian }}</p>    
                                        </div>
                                    </div>
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