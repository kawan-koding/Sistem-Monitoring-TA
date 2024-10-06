@extends('administrator.layout.main')
@section('content')
    <div class="">
        <h5 class="m-0">Informasi Profile</h5>
        <p class="text-muted font-size-13">Perbarui informasi profile anda</p>
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
        <form action="{{ route('apps.profile.update', $profile->id) }}" id="myFormulir" method="post"
            enctype="multipart/form-data">
            @csrf
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12 col-md-4 col-lg-4">
                            <div style="width: 200px; height: 200px; overflow: hidden; border-radius: 50%;"
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
                            <table class="border-none mx-auto" cellpadding="5">
                                @if ($profile->hasRole(['Dosen', 'Admin', 'Kaprodi']))
                                    <tr>
                                        <td class="font-size-13 fw-bold text-end">NIP/NIPPPK/NIK</td>
                                        <td class="font-size-13">:</td>
                                        <td class="font-size-13">{{ $profile->userable->nip }}</td>
                                    </tr>
                                @endif
                                @if ($profile->hasRole(['Dosen', 'Admin', 'Kaprodi']))
                                    <tr>
                                        <td class="font-size-13 fw-bold text-end">NIDN</td>
                                        <td class="font-size-13">:</td>
                                        <td class="font-size-13">{{ $profile->userable->nidn }}</td>
                                    </tr>
                                @endif
                                <tr>
                                    <td class="font-size-13 fw-bold text-end">Username</td>
                                    <td class="font-size-13">:</td>
                                    <td class="font-size-13">{{ $profile->username }}</td>
                                </tr>
                                @if ($profile->hasRole('Mahasiswa'))
                                    <tr>
                                        <td class="font-size-13 fw-bold text-end">NIM</td>
                                        <td class="font-size-13">:</td>
                                        <td class="font-size-13">{{ $profile->userable->nim }}</td>
                                    </tr>
                                @endif
                                <tr>
                                    <td class="font-size-13 fw-bold text-end">Email</td>
                                    <td class="font-size-13">:</td>
                                    <td class="font-size-13">{{ $profile->userable->email }}</td>
                                </tr>
                                @if ($profile->hasRole('Mahasiswa'))
                                    <tr>
                                        <td class="font-size-13 fw-bold text-end">Kelas</td>
                                        <td class="font-size-13">:</td>
                                        <td class="font-size-13">{{ $profile->userable->kelas }}</td>
                                    </tr>
                                @endif
                                <tr>
                                    <td class="font-size-13 fw-bold text-end"
                                        style="white-space: nowrap; vertical-align: top;">Program Studi</td>
                                    <td class="font-size-13" style="vertical-align: top">:</td>
                                    <td class="font-size-13">{{ $profile->userable->programStudi->nama ?? '' }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-sm-12 col-md-8 col-lg-8">
                            <div class="row">
                                <div class="mb-3">
                                    <label for="">Nama <span class="text-danger">*</span></label>
                                    <input type="text" name="name" id="name" class="form-control"
                                        value="{{ $profile->userable->nama_mhs ?? ($profile->userable->name ?? '') }}">
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
                                        <select class="tagging-example form-control" multiple="multiple" name="bidang_keahlian[]">
                                            @foreach ($bidangKeahlian as $item)
                                                <option value="{{$item}}" selected>{{$item}}</option>
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
            </div>
        </form>
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