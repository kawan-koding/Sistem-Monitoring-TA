<!-- sample modal content -->
<div id="myModal" class="modal fade" tabindex="-1" role="dialog"
aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title mt-0" id="myModalLabel">Modal Heading</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"
                aria-label="Close"></button>
        </div>
        <form action="" id="myFormulir" method="post" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
                <div class="mb-3">
                    <label for="">Nama User <span class="text-danger">*</span></label>
                    <input type="text" name="name" id="name" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="">Username <span class="text-danger">*</span></label>
                    <input type="text" name="username" id="username" class="form-control" required>
                    <input type="hidden" name="id" id="idUser">
                    <span class="text-danger">*Jika akan terdaftar role dosen maka username harus NIDN, jika terdaftar mahasiswa username harus NIM</span>
                </div>
                <div id="forPass" class="mb-3">

                </div>
                <div class="mb-3">
                    <label for="">Role Pertama<span class="text-danger">*</span></label>
                    <select name="role" id="role" class="form-control" required>
                        <option value=""></option>
                        <option value="admin">Admin</option>
                        <option value="kaprodi">Kaprodi</option>
                        <option value="dosen">Dosen</option>
                        <option value="mahasiswa">Mahasiswa</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="">Role Kedua</label>
                    <select name="role_2" id="role_2" class="form-control">
                        <option value=""></option>
                        <option value="admin">Admin</option>
                        <option value="kaprodi">Kaprodi</option>
                        <option value="dosen">Dosen</option>
                        <option value="mahasiswa">Mahasiswa</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="">Role Ketiga</label>
                    <select name="role_3" id="role_3" class="form-control">
                        <option value=""></option>
                        <option value="admin">Admin</option>
                        <option value="kaprodi">Kaprodi</option>
                        <option value="dosen">Dosen</option>
                        <option value="mahasiswa">Mahasiswa</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="">Role Keempat</label>
                    <select name="role_4" id="role_4" class="form-control">
                        <option value=""></option>
                        <option value="admin">Admin</option>
                        <option value="kaprodi">Kaprodi</option>
                        <option value="dosen">Dosen</option>
                        <option value="mahasiswa">Mahasiswa</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="">Picture</label>
                    <input type="file" name="picture" class="form-control">
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
