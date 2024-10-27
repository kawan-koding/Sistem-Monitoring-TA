<div class="card shadow-sm mb-4">
    <div class="card-body">
        <div class="row align-items-center">
            <div class="col-8">
                <h5 class="m-0">Cetak Rekapitulasi Nilai</h5>
                <p class="text-muted small m-0">Lakukan cetak rekapitulasi nilai.</p>
            </div>
            <div class="col-4 text-end">
                <a href="{{ route('apps.coming-soon') }}" class="btn btn-outline-dark btn-sm"><i class="bx bx-printer"></i> Cetak Rekapitulasi Nilai</a>
            </div>
        </div>

    </div>
</div>

<div class="card shadow-sm mb-4">
    <div class="card-body">
        <div class="col-12 text-center mb-4">
            <h5 class="mb-0 fw-bold">Rekapitulasi Nilai Seminar Proposal</h5>
        </div>
        <table class="table" width="100%">
            <thead class="bg-light">
                <th>No.</th>
                <th>Penilai</th>
                <th>Nilai</th>
                <th>Nilai Tertimbang</th>
            </thead>
            <tbody>
                <tr>
                    <td>1.</td>
                    <td>Pembimbing 1</td>
                    <td>{{ number_format($recapPemb1, 2) }}</td>
                    <td>30% X {{ number_format($recapPemb1, 2) }} = {{ $recapPemb1 > 0 ? number_format($recapPemb1 * 0.3, 2) : 0 }}</td>
                </tr>
                <tr>
                    <td>2.</td>
                    <td>Pembimbing 2</td>
                    <td>{{ number_format($recapPemb2, 2) }}</td>
                    <td>30% X {{ number_format($recapPemb2, 2) }} = {{ $recapPemb2 > 0 ? number_format($recapPemb2 * 0.3, 2) : 0 }}</td>
                </tr>
                <tr>
                    <td>3.</td>
                    <td>Penguji 1</td>
                    <td>{{ number_format($recapPenguji1, 2) }}</td>
                    <td>20% X {{ number_format($recapPenguji1, 2) }} = {{ $recapPenguji1 > 0 ? number_format($recapPenguji1 * 0.2, 2) : 0 }}</td>
                </tr>
                <tr>
                    <td>4.</td>
                    <td>Penguji 2</td>
                    <td>{{ number_format($recapPenguji2, 2) }}</td>
                    <td>20% X {{ number_format($recapPenguji2, 2) }} = {{ $recapPenguji2 > 0 ? number_format($recapPenguji2 * 0.2, 2) : 0 }}</td>
                </tr>
            </tbody>
            <tfoot class="bg-light">
                <tr>
                    <td colspan="2">Jumlah</td>
                    <td colspan="2">{{ number_format($recapPemb1 + $recapPemb2 + $recapPenguji1 + $recapPenguji2) }}</td>
                </tr>
                <tr>
                    <td colspan="2">Nilai Angka</td>
                    <td colspan="2">{{ number_format(($recapPemb1 > 0 ? $recapPemb1 * 0.3 : 0) + ($recapPemb2 > 0 ? $recapPemb2 * 0.3 : 0) + ($recapPenguji1 > 0 ? $recapPenguji1 * 0.2 : 0) + ($recapPenguji2 > 0 ? $recapPenguji2 * 0.2 : 0), 2) }}</td>
                </tr>
                <tr>
                    <td colspan="2">Nilai Huruf</td>
                    <td colspan="2">{{ grade(($recapPemb1 > 0 ? $recapPemb1 * 0.3 : 0) + ($recapPemb2 > 0 ? $recapPemb2 * 0.3 : 0) + ($recapPenguji1 > 0 ? $recapPenguji1 * 0.2 : 0) + ($recapPenguji2 > 0 ? $recapPenguji2 * 0.2 : 0)) }}</td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>