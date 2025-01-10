<div class="row">
    <div class="col-md-3 col-sm-6 col-12">
        <div class="card shadow-sm border-primary text-white"
            style="border-width: 0px 0px 0px 3px;background: linear-gradient(to right, #3789f5, #222faa);">
            <div class="card-icon">
                <i class="mdi mdi-alert-decagram"></i>
            </div>
            <div class="card-body">
                <h3 class="mb-2">{{ $belumAcc->count() }} </h3>
                <p class="mb-0">Tawaran Topik Yang Belum Divalidasi</p>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6 col-12">
        <div class="card shadow-sm border-primary text-white"
            style="border-width: 0px 0px 0px 3px;background: linear-gradient(to right, #3789f5, #222faa);">
            <div class="card-icon">
                <i class="mdi mdi-file-check"></i>
            </div>
            <div class="card-body">
                <h3 class="mb-2">{{ $sudahAcc->count() }} </h3>
                <p class="mb-0">Tawaran Topik Yang Sudah Divalidasi</p>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6 col-12">
        <div class="card shadow-sm border-primary text-white"
            style="border-width: 0px 0px 0px 3px;background: linear-gradient(to right, #3789f5, #222faa);">
            <div class="card-icon">
                <i class="fa fa-clock"></i>
            </div>
            <div class="card-body">
                <h3 class="mb-2">{{ $taDraft->count() }} </h3>
                <p class="mb-0">Pengajuan TA Yang Belum Divalidasi</p>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6 col-12">
        <div class="card shadow-sm border-primary text-white"
            style="border-width: 0px 0px 0px 3px;background: linear-gradient(to right, #3789f5, #222faa);">
            <div class="card-icon">
                <i class="fa fa-check-circle"></i>
            </div>
            <div class="card-body">
                <h3 class="mb-2">{{ $taAcc->count() }} </h3>
                <p class="mb-0">Pengajuan TA Yang Sudah Divalidasi</p>
            </div>
        </div>
    </div>
</div>