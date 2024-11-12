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
                    <div class="mb-3">
                        <label for="">Judul <span class="text-danger">*</span></label>
                        <textarea type="text" name="judul" id="judul" class="form-control"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="">Deskripsi <span class="text-danger">*</span></label>
                        <textarea type="text" name="deskripsi" id="deskripsi" class="form-control"></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="">Tipe Penyelesaian <span class="text-danger">*</span></label>
                                <select class="form-control" name="tipe" id="tipe">
                                    <option value="" disabled selected hidden>Pilih Jenis Topik</option>
                                    <option value="Kelompok">Berkelompok</option>
                                    <option value="Individu">Individu</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="">Kuota <span class="text-danger">*</span></label>
                                <input type="number" name="kuota" id="kuota" class="form-control" >
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="">Jenis Topik <span class="text-danger">*</span></label>
                        <select class="form-control" name="jenis_ta_id" id="jenis_ta_id">
                            <option value="" disabled selected hidden>Pilih Jenis Topik</option>
                            @foreach ($jenisTa as $item)
                                <option value="{{ $item->id }}">{{$item->nama_jenis}}</option>
                            @endforeach
                            <option value="lainnya">Lainnya</option>
                        </select>
                    </div>
                    <div class="mb-3" id="new_jenis" style="display: none;">
                        <label for="">Masukkan Jenis Topik Baru</label>
                        <input type="text" class="form-control" id="jenis_ta_new" name="jenis_ta_new" placeholder="Masukkan jenis topik">
                    </div>
                    <div class="mb-3">
                        <label for="">Program Studi Tujuan <span class="text-danger">*</span></label>
                        <select class="form-control" name="program_studi_id" id="program_studi_id">
                            <option value="" disabled selected hidden>Pilih Program Studi</option>
                            @foreach ($prodi as $item)
                                <option value="{{ $item->id }}">{{$item->nama}}</option>
                            @endforeach
                        </select>
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


