<!-- sample modal content -->
<div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0" id="myModalLabel"></h5>
            </div>
            <form action="" id="myFormulir" method="post">
                @csrf
                 <input type="hidden" name="dosen_id" id="dosen_id">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="">Kuota Pembimbing 1 <span class="text-danger">*</span></label>
                                <input type="number" name="pembimbing_1" id="pembimbing_1" class="form-control" >
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="">Kuota Pembimbing 2 <span class="text-danger">*</span></label>
                                <input type="number" name="pembimbing_2" id="pembimbing_2" class="form-control" >
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="">Kuota Penguji 1 <span class="text-danger">*</span></label>
                                <input type="number" name="penguji_1" id="penguji_1" class="form-control" >
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="">Kuota Penguji 2 <span class="text-danger">*</span></label>
                                <input type="number" name="penguji_2" id="penguji_2" class="form-control" >
                            </div>
                        </div>
                    </div>
                    @if(session('switchRoles') == 'Admin')
                    <div class="mb-3" id="prodi">
                        <label for="">Program Studi <span class="text-danger">*</span></label>
                        <select name="program_studi_id" id="program_studi_id" class="form-control">
                            <option selected disabled hidden>Pilih Program Studi</option>
                            @foreach ($prodi as $item)
                                <option value="{{ $item->id }}">{{$item->nama}}</option>
                            @endforeach
                        </select>
                    </div>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Keluar</button>
                    <button type="submit" class="btn btn-primary waves-effect waves-light">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>


