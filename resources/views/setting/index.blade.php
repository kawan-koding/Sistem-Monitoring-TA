@extends('layout.admin-main')
@section('content')

<div class="row">
    <div class="col-md-12 col-sm-12 col-g-12">
        <div class="card">
            <div class="card-body">

                <div class="row">
                    <div class="col-6">
                        <center>
                            <div class="">
                                <img src="{{asset('images/'.$logo->value)}}" alt="" class="avatar-lg mx-auto img-thumbnail rounded-circle">
                            </div><br>
                        </center>
                        <center>Logo</center>
                    </div>
                    <div class="col-6">
                        <center>
                            <div class="">
                                <img src="{{asset('images/'.$icon->value)}}" alt="" class="avatar-lg mx-auto img-thumbnail rounded-circle">
                            </div><br>
                        </center>
                        <center>Icon</center>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12 col-sm-12 col-lg-12">
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

                <form action="{{route('admin.settings.store')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6 mb-3">
                            <label for="">Nama</label>
                            <input type="text" name="name" value="{{$name->value ?? ''}}" class="form-control">
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 mb-3">
                            <label for="">Telephone</label>
                            <input type="text" name="telephone" value="{{$telephone->value ?? ''}}" class="form-control">
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 mb-3">
                            <label for="">Alamat</label>
                            <input type="text" name="address" value="{{$address->value ?? ''}}" class="form-control">
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 mb-3">
                            <label for="">Icon</label>
                            <input type="file" name="icon" class="form-control">
                            @if ($errors->has('icon'))
                            <span class="text-danger">{{ $errors->first('icon') }}</span>
                            @endif
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 mb-3">
                            <label for="">Logo</label>
                            <input type="file" name="logo" class="form-control">
                            @if ($errors->has('logo'))
                            <span class="text-danger">{{ $errors->first('logo') }}</span>
                            @endif
                        </div>
                        <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
