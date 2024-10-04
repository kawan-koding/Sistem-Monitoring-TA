@extends('layout.admin-main')
@section('content')
    <div class="row">
        <div class="col-sm-12 col-md-3 col-lg-3">
            <h5 class="">Informasi Profile</h5>
            <p class="text-muted font-size-13">Perbarui informasi profile anda</p>
        </div>
        <div class="col-sm-12 col-md-9 col-lg-9">
            <form action="" id="myFormulir" method="post">
                @csrf
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            @if (in_array('dosen', $user->roles))    
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <div class="mb-3">
                                        <label for="">NIP/NIPPPK/NIK <span class="text-danger">*</span></label>
                                        <input type="text" name="nip" id="nip" class="form-control" value="">
                                    </div>
                                </div>
                            @endif
                            @if (in_array('dosen', $user->roles))    
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <div class="mb-3">
                                        <label for="">NIDN <span class="text-danger">*</span></label>
                                        <input type="text" name="nidn" id="nidn" class="form-control" value="">
                                    </div>
                                </div>
                            @endif
                            <div class="col-sm-12 col-md-6 col-lg-6">
                                <div class="mb-3">
                                    <label for="">Nama <span class="text-danger">*</span></label>
                                    <input type="text" name="name" id="name" class="form-control" value="{{$profile->userable->nama_mhs}}">
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6 col-lg-6">
                                <div class="mb-3">
                                    <label for="">Username <span class="text-danger">*</span></label>
                                    <input type="text" name="username" id="username" class="form-control" value="{{$profile->username}}" disabled>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6 col-lg-6">
                                <div class="mb-3">
                                    <label for="">Email <span class="text-danger">*</span></label>
                                    <input type="text" name="email" id="email" class="form-control" value="{{$profile->userable->email}}" disabled>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6 col-lg-6">
                                <div class="mb-3">
                                    <label for="">No. Telp <span class="text-danger">*</span></label>
                                    <input type="tel" name="telp" id="telp" class="form-control" value="{{$profile->userable->telp}}">
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6 col-lg-6">
                                <div class="mb-3">
                                    <label for="">NIM <span class="text-danger">*</span></label>
                                    <input type="text" name="nim" id="nim" class="form-control" value="{{$profile->userable->nim}}" disabled>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6 col-lg-6">
                                <div class="mb-3">
                                    <label for="">Kelas <span class="text-danger">*</span></label>
                                    <input type="text" name="kelas" id="kelas" class="form-control" value="{{$profile->userable->kelas}}" disabled>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6 col-lg-6">
                                <div class="mb-3">
                                    <label for="">Program Studi <span class="text-danger">*</span></label>
                                    <input type="text" name="program_studi" id="program_studi" class="form-control" value="{{$profile->userable->programStudi->nama}}" disabled>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6 col-lg-6">
                                <div class="mb-3">
                                    <label for="">Jenis Kelamin <span class="text-danger">*</span></label>
                                    <input type="text" name="jenis_kelamin" id="jenis_kelamin" class="form-control" value="{{$profile->userable->jenis_kelamin}}">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="">Foto Profil</label>
                                <div class="border p-4 text-center" style="border-radius: 8px">
                                    <input type="file" name="foto_profile" id="foto_profile" class="d-none">
                                    <label for="foto_profile" style="cursor: pointer"> 
                                        <i class="bx bx-cloud-upload text-secondary" style="font-size: 50px"></i>
                                        <p class="mt-1 text-muted">Drag and drop a file here or click</p>
                                    </label>
                                </div>
                            </div>
                            <div class="my-3">
                                <button class="btn btn-primary" type="submit"><i class="bx bx-save"></i> Simpan</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection