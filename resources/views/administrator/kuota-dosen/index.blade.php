@extends('administrator.layout.main')

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-g-12">
        <div class="card">
            <div class="card-body">
                @can('update-kuota')
                    <button onclick="tambahData()" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah</button>
                @endcan
                    <hr>
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="mdi mdi-check-all me-2"></i> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                            </button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="mdi mdi-block-helper me-2"></i>{{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                            </button>
                        </div>
                    @endif
                    
                    @if ($errors->any())
                        <div class="alert alert-error alert-danger alert-dismissible fade show" role="alert">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                            </button>
                        </div>
                    @endif
                <div class="table-responsive">
                    <table class="table table-striped" id="datatable">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th width="20%">NIP/NIPPPK/NIK</th>
                                <th width="40%">Nama</th>
                                <th style="width: 15%; white-space: nowrap;">Pembimbing 1</th>
                                <th style="width: 15%; white-space: nowrap;">Pembimbing 2</th>
                                <th style="width: 15%; white-space: nowrap;">Penguji 1</th>
                                <th style="width: 15%; white-space: nowrap;">Penguji 2</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $item)
                            <?php
                                $kuota = \App\Models\KuotaDosen::where('dosen_id', $item->id)->where('periode_ta_id', $periode->id)->first();
                            ?>
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$item->nip}}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="">
                                            <strong>{{ucfirst($item->name)}}</strong>
                                            <p class="m-0 p-0 text-muted small">NIDN : {{$item->nidn}}</p>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <input type="number" id="pembimbing_1{{$item->id}}" value="{{$kuota->pembimbing_1 ?? 0}}" class="form-control" onchange="changeKuota('pembimbing_1', 'pembimbing_1{{$item->id}}', '{{$periode->id}}', '{{$item->id}}')">
                                </td>
                                <td>
                                    <input type="number" id="pembimbing_2{{$item->id}}" value="{{$kuota->pembimbing_2 ?? 0}}" class="form-control" onchange="changeKuota('pembimbing_2', 'pembimbing_2{{$item->id}}', '{{$periode->id}}', '{{$item->id}}')">
                                </td>
                                <td>
                                    <input type="number" id="penguji_1{{$item->id}}" value="{{$kuota->penguji_1 ?? 0}}" class="form-control" onchange="changeKuota('penguji_1', 'penguji_1{{$item->id}}', '{{$periode->id}}', '{{$item->id}}')">
                                </td>
                                <td>
                                    <input type="number" id="penguji_2{{$item->id}}" value="{{$kuota->penguji_2 ?? 0}}" class="form-control" onchange="changeKuota('penguji_2', 'penguji_2{{$item->id}}', '{{$periode->id}}', '{{$item->id}}')">
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

@include('administrator.kuota-dosen.partials.modal')
@endsection