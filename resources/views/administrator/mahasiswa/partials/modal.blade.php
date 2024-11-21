<!-- sample modal content -->
<div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0" id="myModalLabel"></h5>
            </div>
            <form action="" id="myFormulir" method="post">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 col-lg-6 col-sm-12 mb-3">
                            <label for="">Kelas <span class="text-danger">*</span></label>
                            <input type="text" name="kelas" id="kelas" class="form-control" placeholder="Kelas" required>
                            <input type="hidden" name="id" id="idMhs">
                        </div>
                        <div class="col-md-6 col-lg-6 col-sm-12 mb-3">
                            <label for="">NIM <span class="text-danger">*</span></label>
                            <input type="text" name="nim" id="nim" class="form-control" placeholder="NIM" required>
                        </div>
                        <div class="col-md-6 col-lg-6 col-sm-12 mb-3">
                            <label for="">Nama <span class="text-danger">*</span></label>
                            <input type="text" name="nama_mhs" id="nama_mhs" class="form-control" placeholder="Nama Mahasiswa" required>
                        </div>
                        <div class="col-md-6 col-lg-6 col-sm-12 mb-3">
                            <label for="">Email <span class="text-danger">*</span></label>
                            <input type="text" name="email" id="email" class="form-control" placeholder="Email" required>
                        </div>
                        <div class="col-md-6 col-lg-6 col-sm-12 mb-3">
                            <label for="">Jenis Kelamin</label>
                            <select name="jenis_kelamin" id="jenis_kelamin"  class="form-control">
                                <option value="">Pilih</option>
                                <option value="Laki-laki">Laki-Laki</option>
                                <option value="Perempuan">Perempuan</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                        </div>
                        <div class="col-md-6 col-lg-6 col-sm-12 mb-3">
                            <label for="">Telp</label>
                            <input type="text" name="telp" id="telp" class="form-control" placeholder="Nomor">
                        </div>
                        <div class="mb-3">
                            <label for="">Program Studi <span class="text-danger">*</span></label>
                            <select name="program_studi_id" id="program_studi_id" required class="form-control">
                                <option value="" selected disabled hidden>Pilih Program Studi</option>
                                @foreach ($prodi as $item)
                                    <option value="{{ $item->id }}">{{$item->nama}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="">Periode <span class="text-danger">*</span></label>
                            <select name="periode_ta_id" id="periode_ta_id" required class="form-control">
                                <option value="" selected disabled hidden>Pilih Periode</option>
                                @foreach ($periode as $item)
                                    <option value="{{ $item->id }}">{{$item->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect"
                        data-bs-dismiss="modal">Keluar</button>
                    <button type="submit"
                        class="btn btn-primary waves-effect waves-light">Simpan</button>
                </div>
            </form>
        </div>
</div>
</div>

<div id="myModalImport" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0" id="myModalLabelImport">Import Mahasiswa</h5>
            </div>
            <form action="" enctype="multipart/form-data" id="myImportFormulir" method="post">
                @csrf
                <div class="modal-body">
                    <a href="{{ route('apps.mahasiswa.export') }}" target="_blank" class="btn btn-sm btn-success"><i class="fa fa-file-excel"></i> Unduh Template</a>
                    <hr>
                    <div>
                        <label for="">File</label>
                        <input type="file" name="file" id="file" class="form-control filepond" required>
                        <span class="text-danger">*csv,xls,xlsx</span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Keluar</button>
                    <button type="submit" class="btn btn-primary waves-effect waves-light">Simpan</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
</div>