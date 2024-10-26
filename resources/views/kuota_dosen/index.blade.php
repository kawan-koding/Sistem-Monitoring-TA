@extends('layout.admin-main')
@section('content')



<div class="row">
    <div class="col-md-12 col-sm-12 col-g-12">
        <div class="card">
            <div class="card-body">
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
                <div class="table-responsive">
                    <table class="table table-striped" id="datatable">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th>NIP/NIPPPK/NIK</th>
                                <th>NIDN</th>
                                <th>Nama</th>
                                <th width="13%">Pembimbing 1</th>
                                <th width="13%">Pembimbing 2</th>
                                <th width="13%">Penguji 1</th>
                                <th width="13%">Penguji 2</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($dataDosen as $item)
                            <?php
                                $kuota = \App\Models\KuotaDosen::where('dosen_id', $item->id)->where('periode_ta_id', $periode->id)->first();
                            ?>
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$item->nip}}</td>
                                <td>{{$item->nidn}}</td>
                                <td>{{$item->name}}</td>
                                <td>
                                    <input type="number" id="pemb_1{{$item->id}}" value="{{$kuota->pemb_1 ?? 0}}" class="form-control" onchange="changeKuota('pemb_1', 'pemb_1{{$item->id}}', '{{$periode->id}}', '{{$item->id}}')">
                                </td>
                                <td>
                                    <input type="number" id="pemb_2{{$item->id}}" value="{{$kuota->pemb_2 ?? 0}}" class="form-control" onchange="changeKuota('pemb_2', 'pemb_2{{$item->id}}', '{{$periode->id}}', '{{$item->id}}')">
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

<script>
    const formUrlChangeOrCreate = "{{route('admin.kuotadosen.store')}}"
</script>
@endsection
