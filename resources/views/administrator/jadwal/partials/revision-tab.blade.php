<div class="row align-items-center">
    <h5 class="fw-bold mb-0">Lembar Revisi</h5>
    <strong class="mb-0">Dianni Yusuf, S.Kom., M.Kom. (Pembimbing 1)</strong>
    <p class="text-muted small m-0">Tuliskan revisi untuk: <strong>Putri Indah Lestari</strong></p>
    {{-- <div class="col-md-3 col-12 text-center">
        <button class="btn btn-outline-dark btn-sm"><i class="bx bx-printer"></i> Cetak Lembar Revisi</button>
    </div> --}}
</div>
<hr>
<div class="">
    <form action="" method="POST">
        @csrf
        <textarea name="revisi" id="elm1"></textarea>
        <br>
        <div class="text-end">
            <button class="btn btn-primary" type="submit">Simpan</button>
        </div>
    </form>
</div>