<!-- sample modal content -->
<div id="myModal" class="modal fade" tabindex="-1" role="dialog"
aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title mt-0" id="myModalLabel"></h5>
        </div>
        <form action="" id="myFormulir" method="post" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
                <div class="mb-3">
                        <label for="">Nama User <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" id="name" placeholder="Nama User"
                            autocomplete="off">
                    </div>
                    <div class="row">
                        <div class="col-sm-6 col-12">
                            <div class="mb-3">
                                <label for="">Email <span class="text-danger">*</span></label>
                                <input type="email" name="email" class="form-control" id="email" placeholder="Email"
                                    autocomplete="off">
                            </div>
                        </div>
                        <div class="col-sm-6 col-12">
                            <div class="mb-3">
                                <label for="">Username <span class="text-danger">*</span></label>
                                <input type="text" name="username" class="form-control" id="username" placeholder="Username"
                                    autocomplete="off">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 col-12">
                            <div class="mb-3">
                                <label for="">Password <span class="text-danger">*</span></label>
                                <input type="password" name="password" id="password" class="form-control" placeholder="Password"
                                    autocomplete="autocomplete">
                            </div>
                        </div>
                        <div class="col-sm-6 col-12">
                            <div class="mb-3">
                                <label for="">Confirm Password <span class="text-danger">*</span></label>
                                <input type="password" name="confirm_password" id="confirm_password" class="form-control"
                                    placeholder="Confirm Password" autocomplete="autocomplete">
                            </div>
                        </div>
                    </div>
                <div class="mb-3">
                    <label for="">Role<span class="text-danger">*</span></label>
                    <select name="roles[]" id="roles" multiple class="select2 form-select" autocomplete="off" required>
                        <option value=""></option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->name }}">{{ $role->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="">Picture</label>
                    <input type="file" name="picture" class="form-control filepond">
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
