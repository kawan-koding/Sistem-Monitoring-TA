<div class="row">
    <div class="col-md-3 col-sm-6 col-12">
        <div class="card shadow-sm border-primary text-white"
            style="border-width: 0px 0px 0px 3px;background: linear-gradient(to right, #3789f5, #222faa);">
            <div class="card-icon">
                <i class="bx bxs-user-detail"></i>
            </div>
            <div class="card-body">
                <h3 class="mb-2">{{ $bimbing->count() }}</h3>
                <p class="mb-0">Total Mahasiswa Bimbingan</p>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6 col-12">
        <div class="card shadow-sm border-primary text-white"
            style="border-width: 0px 0px 0px 3px;background: linear-gradient(to right, #3789f5, #222faa);">
            <div class="card-icon">
                <i class="bx bx-user-voice"></i>
            </div>
            <div class="card-body">
                <h3 class="mb-2">{{ $uji->count() }} </h3>
                <p class="mb-0">Total Mahasiswa Uji</p>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6 col-12">
        <div class="card shadow-sm border-primary text-white"
            style="border-width: 0px 0px 0px 3px;background: linear-gradient(to right, #3789f5, #222faa);">
            <div class="card-icon">
                <i class="bx bx-edit-alt"></i>
            </div>
            <div class="card-body">
                <h3 class="mb-2">{{ $kuota->sum('pembimbing_1') ?? 0 }} </h3>
                <p class="mb-0">Jumlah Kuota Pembimbing 1</p>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6 col-12">
        <div class="card shadow-sm border-primary text-white"
            style="border-width: 0px 0px 0px 3px;background: linear-gradient(to right, #3789f5, #222faa);">
            <div class="card-icon">
                <i class="bx bx-user-pin"></i>
            </div>
            <div class="card-body">
                <h3 class="mb-2">{{ $sisaKuota ?? 0 }}</h3>
                <p class="mb-0">Sisa Kuota Pembimbing 1</p>
            </div>
        </div>
    </div>
</div>