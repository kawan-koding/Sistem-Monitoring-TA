<!-- sample modal content -->
<div id="myModal" class="modal fade" tabindex="-1" role="dialog"
aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title mt-0" id="myModalLabel">Modal Heading
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"
                aria-label="Close"></button>
        </div>
        <form action="" id="myFormulir" method="post">
            @csrf
            <div class="modal-body">
                <div class="mb-3">
                    <label for="">Kode Program Studi <span class="text-danger">*</span> </label>
                    <input type="text" name="kode" id="kode" placeholder="Kode" class="form-control" autocomplete="off">
                </div>
                <div class="mb-3">
                    <label for="">Nama Program Studi <span class="text-danger">*</span></label>
                    <input type="text" name="nama" id="nama" placeholder="Nama program studi" autocomplete="off" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="">Singkatan Program Studi <span class="text-danger">*</span></label>
                    <input type="text" name="display" id="display" placeholder="Singkatan program studi" autocomplete="off" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="">Jurusan <span class="text-danger">*</span></label>
                    <select name="jurusan_id" id="jurusan_id" required class="form-control">
                        <option value="" selected disabled hidden>Pilih Jurusan</option>
                        @foreach ($jurusan as $item)
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
    <!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
</div>
<!-- /.modal -->
