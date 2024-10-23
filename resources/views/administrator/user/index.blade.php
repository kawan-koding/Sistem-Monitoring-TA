@extends('administrator.layout.main')

@section('content')

<div class="row">
    <div class="col-md-12 col-sm-12 col-g-12">
        <div class="card">
            <div class="card-body">
                @can('create-users')
                {{-- <a href="javascript:void(0);" onclick="tambahData()" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah</a>
                <hr> --}}
                @endcan
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
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $item)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="me-3" style="width: 40px; height: 40px; border-radius: 50%;overflow: hidden">
                                            <img src="{{ $item->image == null ? 'https://ui-avatars.com/api/?background=random&name='. $item->name : asset('storage/images/users/'. $item->image) }}" width="100%">
                                        </div>  
                                        <div>
                                            <strong>{{ ucfirst($item->name) }}</strong>
                                            <p class="m-0 p-0 text-muted small">{{ $item->username }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $item->email }}</td>
                               <td>{{ implode(', ', $item->getRoleNames()->toArray()) }}</td>
                                <td>
                                    @can('update-users')
                                    <button onclick="editData('{{ $item->id }}', '{{route('apps.users.show', $item->id)}}')" class="btn btn-outline-primary btn-sm mx-1 my-1"><i class="bx bx-edit-alt"></i></button>
                                    @endcan
                                    @can('delete-users')
                                    <button onclick="hapusUser('{{ $item->id }}', '{{ route('apps.users.delete', $item->id) }}')" class="btn btn-outline-dark btn-sm mx-1 my-1"><i class="bx bx-trash"></i></a>
                                    @endcan
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

@include('administrator.user.partials.modal')
@endsection
