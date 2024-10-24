<div class="card shadow-sm mb-4">
    <div class="card-body">
        <div class="col-12 mb-4">
            <h5 class="mb-0 fw-bold">Lembar Penilaian</h5>
            <strong>Dianni Yusuf, S.Kom., M.Kom. (Pembimbing 1)</strong>
            <p class="text-muted small">Berikan nilai untuk : <strong>Putri Indah Lestari</strong></p>
        </div>
        <form action="" method="post">
            @csrf
            <table class="table" width="100%">
                <thead class="bg-light">
                    <th>No.</th>
                    <th>Aspek</th>
                    <th>Angka</th>
                    <th>Huruf</th>
                </thead>
                <tbody>
                    <tr>
                        <td width="25">1.</td>
                        <td>Penguasaan Materi</td>
                        <td>
                            <input type="number" class="form-control w-25">
                        </td>
                        <td>-</td>
                    </tr>
                    <tr>
                        <td width="25">2.</td>
                        <td>Tinjauan Pustaka</td>
                        <td>
                            <input type="number" class="form-control w-25">
                        </td>
                        <td>-</td>
                    </tr>
                    <tr>
                        <td width="25">3.</td>
                        <td>Ketepatan Menjawab Pertanyaan</td>
                        <td>
                            <input type="number" class="form-control w-25">
                        </td>
                        <td>-</td>
                    </tr>
                    <tr>
                        <td width="25">4.</td>
                        <td>Kedalam Materi</td>
                        <td>
                            <input type="number" class="form-control w-25">
                        </td>
                        <td>-</td>
                    </tr>
                    <tr>
                        <td width="25">5.</td>
                        <td>Etika</td>
                        <td>
                            <input type="number" class="form-control w-25">
                        </td>
                        <td>-</td>
                    </tr>
                    <tr>
                        <td width="25">6.</td>
                        <td>Kedisiplinan</td>
                        <td>
                            <input type="number" class="form-control w-25">
                        </td>
                        <td>-</td>
                    </tr>
                </tbody>
                <tfoot class="bg-light">
                    <tr>
                        <td colspan="2">Total Nilai Angka</td>
                        <td colspan="2">-</td>
                    </tr>
                    <tr>
                        <td colspan="2">Total Nilai Huruf</td>
                        <td colspan="2">-</td>
                    </tr>
                </tfoot>
            </table>
            <div class="text-end mt-4">
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>

