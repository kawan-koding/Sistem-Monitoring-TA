<div class="card shadow-sm mb-4">
    <div class="card-body">
        <div class="row align-items-center">
            <div class="col-8">
                <h5 class="m-0">Cetak Lembar Penilaian</h5>
                <p class="text-muted small m-0">Lakukan cetak seluruh lembar penilaian.</p>
            </div>
            <div class="col-4 text-end">
                <a href="{{ route('apps.cetak.nilai', $data->id) }}" target="_blank" class="btn btn-outline-dark btn-sm"><i
                        class="bx bx-printer"></i> Cetak Lembar Penilaian</a>
            </div>
        </div>

    </div>
</div>

@foreach ($bimbingUjis as $bimbingUji)
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <div class="col-12 text-center mb-4">
                <h5 class="mb-0 fw-bold">Lembar Penilaian</h5>
                <strong>({{ $bimbingUji->dosen->name }})</strong>
                <p class="text-muted small">{{ ucfirst($bimbingUji->jenis) }} {{ $bimbingUji->urut }}</p>
            </div>
            <table class="table" width="100%">
                <thead class="bg-light">
                    <th>No.</th>
                    <th>Aspek</th>
                    <th>Angka</th>
                    <th>Huruf</th>
                </thead>
                <tbody>
                    @foreach ($kategoriNilais as $key => $category)
                    {{-- @dd($bimbingUji->penilaian->where('kategori_nilai_id', $category->id)->where('type', 'Seminar')) --}}
                        <tr>
                            <td width="25">{{ $key + 1 }}.</td>
                            <td>{{ $category->nama }}</td>
                            <td>{{ $bimbingUji->penilaian->where('kategori_nilai_id', $category->id)->where('type', 'Seminar')->first()->nilai ?? '0' }}
                            </td>
                            <td>{{ grade($bimbingUji->penilaian->where('kategori_nilai_id', $category->id)->where('type', 'Seminar')->first()->nilai ?? 0) }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot class="bg-light">
                    <tr>
                        <td colspan="2">Total Nilai Angka</td>
                        <td colspan="2">
                            {{ number_format($bimbingUji->penilaian->sum('nilai') > 0 ? $bimbingUji->penilaian->where('type', 'Seminar')->sum('nilai') / $bimbingUji->penilaian->count() : 0, 2, '.', '.') }}
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">Total Nilai Huruf</td>
                        <td colspan="2">
                            {{ grade($bimbingUji->penilaian->sum('nilai') > 0 ? $bimbingUji->penilaian->where('type', 'Seminar')->sum('nilai') / $bimbingUji->penilaian->count() : 0) }}
                        </td>
                    </tr>
                </tfoot>
            </table>
            <div class="col-12 my-3">
                <strong>Kriteria Penilaian :</strong><br />
                <table cellpadding="3">
                    <tr>
                        <td>> 80 - 100</td>
                        <td>: Huruf Mutu (A)</td>
                    </tr>
                    <tr>
                        <td>> 75 - 80</td>
                        <td>: Huruf Mutu (AB)</td>
                    </tr>
                    <tr>
                        <td>> 65 - 75</td>
                        <td>: Huruf Mutu (B)</td>
                    </tr>
                    <tr>
                        <td>> 60 - 65</td>
                        <td>: Huruf Mutu (BC)</td>
                    </tr>
                    <tr>
                        <td>> 55 - 60</td>
                        <td>: Huruf Mutu (C)</td>
                    </tr>
                    <tr>
                        <td>> 40 - 55</td>
                        <td>: Huruf Mutu (D)</td>
                    </tr>
                    <tr>
                        <td>≤ 80 - 100</td>
                        <td>: Huruf Mutu (E)</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
@endforeach
