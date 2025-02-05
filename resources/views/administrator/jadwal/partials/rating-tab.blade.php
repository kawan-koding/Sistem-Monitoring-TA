<div class="card shadow-sm mb-4">
    <div class="card-body">
        <div class="col-12 mb-4">
            <h5 class="mb-0 fw-bold">Lembar Penilaian</h5>
            <strong>{{ getInfoLogin()->userable->name }}
                ({{ ucfirst($data->tugas_akhir->bimbing_uji()->where('dosen_id', getInfoLogin()->userable_id)->first()->jenis) }}
                {{ $data->tugas_akhir->bimbing_uji()->where('dosen_id', getInfoLogin()->userable_id)->first()->urut }})</strong>
            <p class="text-muted small">Berikan nilai untuk :
                <strong>{{ $data->tugas_akhir->mahasiswa->nama_mhs }}</strong></p>
        </div>
        <form action="{{ route('apps.jadwal.nilai', $data->id) }}" method="post">
            @csrf
            <table class="table" width="100%">
                <thead class="bg-light">
                    <th>No.</th>
                    <th>Aspek</th>
                    <th>Angka</th>
                    <th>Huruf</th>
                </thead>
                <tbody>
                    @if ($kategoriNilais->count() > 0)
                        @foreach ($kategoriNilais as $kategoriNilai)
                            <tr>
                                <td width="25">{{ $loop->iteration }}.</td>
                                <td>{{ $kategoriNilai->nama }}</td>
                                <td>
                                    <input type="text" name="nilai_{{ $kategoriNilai->id }}"
                                        data-grade-display="#grade-display-{{ $kategoriNilai->id }}"
                                        class="form-control numberOnly text-center w-25"
                                        value="{{ $nilais->where('kategori_nilai_id', $kategoriNilai->id)->first()->nilai ?? '' }}">
                                </td>
                                <td id="grade-display-{{ $kategoriNilai->id }}">
                                    {{ grade($nilais->where('kategori_nilai_id', $kategoriNilai->id)->first()->nilai ?? 0) }}
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="4" class="text-center">Belum ada aspek nilai.</td>
                        </tr>
                    @endif
                </tbody>
                <tfoot class="bg-light">
                    <tr>
                        <td colspan="2">Total Nilai Angka</td>
                        <td colspan="2" class="average-display">
                            {{ number_format($nilais->sum('nilai') > 0 ? $nilais->sum('nilai') / $nilais->count() : 0, 2, '.', ',') }}
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">Total Nilai Huruf</td>
                        <td colspan="2" class="average-grade-display">
                            {{ grade($nilais->sum('nilai') > 0 ? $nilais->sum('nilai') / $nilais->count() : 0) }}</td>
                    </tr>
                </tfoot>
            </table>
            <div class="row">
                <div class="col-sm-6 col-12">
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
                <div class=" col-sm-6 col-12 text-end mt-4">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>
