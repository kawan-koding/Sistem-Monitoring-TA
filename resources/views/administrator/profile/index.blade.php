@extends('administrator.layout.main')
@section('content')
    <div class="row">
        <div class="col-sm-12 col-md-4">
            <h5 class="m-0">Informasi Profile</h5>
            <p class="text-muted font-size-13">Perbarui informasi profile</p>
        </div>
        <div class="col-sm-12 col-md-8">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="mdi mdi-check-all me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    </button>
                </div>
            @endif
            @if (session('error'))
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
                </div>
            @endif
            <form action="{{ route('apps.profile.update', $profile->id) }}" id="myFormulir" method="post"
                enctype="multipart/form-data">
                @csrf
                <div class="card">
                    <div class="card-body">
                        <div style="width: 175px; height: 175px; overflow: hidden; border-radius: 50%; border: 1px; border-color:lightslategrey"
                            class="d-block mx-auto">
                            <img src="{{ asset('storage/images/users/' . Auth::user()->image) }}" alt=""
                                class="w-100">
                        </div>
                        <div class="d-flex justify-content-center">
                            <label for="fileInput" class="text-center p-0">
                                <input type="file" id="fileInput" class="d-none" name="fileImage"
                                    onchange="this.form.submit()">
                                <div class="btn btn-primary btn-sm mt-2 small"><i class="bx bx-camera small"></i> Ubah
                                    Foto</div>
                            </label>
                        </div>
                        <p class="text-center small text-muted fst-italic">
                            Unggah foto profil dalam format
                            <br>
                            JPG/JPEG/PNG
                        </p>
                        <div class="row">
                            @if (getInfoLogin()->hasRole('Dosen') || getInfoLogin()->hasRole('Kaprodi'))
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <div class="mb-3">
                                        <label for="">NIP/NIPPPK/NIK <span class="text-danger">*</span></label>
                                        <input type="text" name="nip" id="nip" class="form-control" disabled
                                            value="{{ $profile->userable->nip ?? '' }}">
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <div class="mb-3">
                                        <label for="">NIDN <span class="text-danger">*</span></label>
                                        <input type="text" name="nidn" id="nidn" class="form-control" disabled
                                            value="{{ $profile->userable->nidn ?? '' }}">
                                    </div>
                                </div>
                            @endif
                            @if ($profile->hasRole('Mahasiswa'))
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <div class="mb-3">
                                        <label for="">NIM <span class="text-danger">*</span></label>
                                        <input type="text" name="nim" id="nim" class="form-control" disabled
                                            value="{{ $profile->userable->nim ?? '' }}">
                                    </div>
                                </div>
                            @endif
                            <div class="col-sm-12 col-md-6 col-lg-6">
                                <div class="mb-3">
                                    <label for="">Nama <span class="text-danger">*</span></label>
                                    <input type="text" name="name" id="name" class="form-control"
                                        value="{{ $profile->userable->nama_mhs ?? ($profile->userable->name ?? '') }}">
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6 col-lg-6">
                                <div class="mb-3">
                                    <label for="">Username <span class="text-danger">*</span></label>
                                    <input type="text" name="username" id="username" class="form-control" disabled
                                        value="{{ $profile->username ?? '' }}">
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6 col-lg-6">
                                <div class="mb-3">
                                    <label for="">Email <span class="text-danger">*</span></label>
                                    <input type="email" name="email" id="email" class="form-control"
                                        value="{{ $profile->userable->email ?? '' }}">
                                </div>
                            </div>
                            @if ($profile->hasRole('Mahasiswa'))
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <div class="mb-3">
                                        <label for="">Kelas <span class="text-danger">*</span></label>
                                        <input type="text" name="kelas" id="kelas" class="form-control"
                                            disabled value="{{ $profile->userable->kelas ?? '' }}">
                                    </div>
                                </div>
                            @endif
                            <div class="col-sm-12 col-md-6 col-lg-6">
                                <div class="mb-3">
                                    <label for="">Program Studi <span class="text-danger">*</span></label>
                                    <input type="text" name="programStudi" id="programStudi" class="form-control"
                                        disabled value="{{ $profile->userable->programStudi->nama ?? '' }}">
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6 col-lg-6">
                                <div class="mb-3">
                                    <label for="">No. Telp <span class="text-danger">*</span></label>
                                    <input type="tel" name="telp" id="telp" class="form-control"
                                        value="{{ $profile->userable->telp ?? '' }}">
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6 col-lg-6">
                                <div class="mb-3">
                                    <label for="">Jenis Kelamin <span class="text-danger">*</span></label>
                                    <select name="jenis_kelamin" id="" class="form-control">
                                        <option value="L"
                                            {{ isset($profile->userable->jenis_kelamin) ? ($profile->userable->jenis_kelamin == 'Laki-laki' || $profile->userable->jenis_kelamin == 'Laki-laki' ? 'selected' : '') : '' }}>
                                            Laki-laki</option>
                                        <option value="P"
                                            {{ isset($profile->userable->jenis_kelamin) ? ($profile->userable->jenis_kelamin == 'Perempuan' || $profile->userable->jenis_kelamin == 'Perempuan' ? 'selected' : '') : '' }}>
                                            Perempuan</option>
                                    </select>
                                </div>
                            </div>
                            @if ($profile->hasRole(['Dosen', 'Admin', 'Kaprodi']))
                                <div class="mb-3">
                                    <label for="">Bidang Keahlian</label>
                                    <select class="tagging-example form-control" multiple="multiple"
                                        name="bidang_keahlian[]">
                                        @foreach ($bidangKeahlian as $item)
                                            <option value="{{ $item }}" selected>{{ $item }}</option>
                                        @endforeach
                                    </select>
                                    {{-- <span class="small text-danger"><i>*Tekan enter untuk menambahkan bidang keahlian dan gunakan tanda (-) sebagai sebagai pemisah</i></span><br> --}}
                                </div>
                            @endif
                            @if ($profile->hasRole(['Dosen', 'Admin', 'Kaprodi']))
                                <div class="mb-3">
                                    <label for="">Tanda Tangan</label>
                                    <div class="border p-4 text-center" style="border-radius: 8px">
                                        <input type="text" name="foto_profile" id="foto_profile"
                                            class="form-control filepond">
                                        @if (!is_null($profile->userable->ttd))
                                            <a href="{{ asset('storage/images/dosen/' . $profile->userable->ttd) }}"
                                                class="btn btn-primary btn-sm w-100" target="_blank"> Lihat Tanda
                                                Tangan</a>
                                        @endif
                                    </div>
                                </div>
                            @endif
                            <div class="my-2 text-end">
                                <button class="btn btn-primary" type="submit"><i class="bx bx-save"></i>
                                    Simpan</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <hr>
    <div class="row">
        <div class="col-sm-12 col-md-4">
            <h5 class="m-0">Ubah Kata Sandi</h5>
            <p class="text-muted font-size-13">Perbarui kata sandi</p>
        </div>
        <div class="col-sm-12 col-md-8">
            <form action="{{route('apps.profile.update-password', $profile->id)}}" id="myFormulir" method="post">
                @csrf
                <div class="card">
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="">Kata Sandi Lama <span class="text-danger">*</span></label>
                            <input type="password" name="passwordOld" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="">Kata Sandi Baru <span class="text-danger">*</span></label>
                            <input type="password" name="passwordNew" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="">Konfirmasi Kata Sandi Baru <span class="text-danger">*</span></label>
                            <input type="password" name="confirmPassword" class="form-control">
                        </div>
                        <div class="my-2 text-end">
                            <button type="submit" class="btn btn-primary"><i class="bx bx-save"></i> Simpan</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function() {
            $('.tagging-example').select2({
                tags: true,
                placeholder: "Tambahkan Bidang Keahlian",
                tokenSeparators: [','],
            })
        });
    </script>
@endsection
