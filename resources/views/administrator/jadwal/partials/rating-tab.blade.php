<div class="card shadow-sm mb-4">
    <div class="card-body">
        {{-- @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="mdi mdi-check-all me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
            </button>
        </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="mdi mdi-block-helper me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                </button>
            </div>
        @endif
        @if ($errors->any())
        <div class="alert alert-error alert-danger alert-dismissible fade show" role="alert">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
            </button>
        </div>
        @endif --}}
        <div class="col-12 mb-4">
            <h5 class="mb-0 fw-bold">Lembar Penilaian</h5>
            <strong>{{ getInfoLogin()->userable->name }} ({{ ucfirst($data->tugas_akhir->bimbing_uji()->where('dosen_id', getInfoLogin()->userable_id)->first()->jenis) }} {{ $data->tugas_akhir->bimbing_uji()->where('dosen_id', getInfoLogin()->userable_id)->first()->urut }})</strong>
            <p class="text-muted small">Berikan nilai untuk : <strong>{{ $data->tugas_akhir->mahasiswa->nama_mhs }}</strong></p>
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
                    @if($kategoriNilais->count() > 0)
                        @foreach ($kategoriNilais as $item)
                            <tr>
                                <td width="25">{{ $loop->iteration }}.</td>
                                <td>{{ $item->nama }}</td>
                                <td>
                                    <input type="text" name="nilai_{{ $item->id }}" data-grade-display="#grade-display-{{ $item->id }}" class="form-control numberOnly text-center w-25" value="{{ $nilais->where('kategori_nilai_id', $item->id)->first()->nilai ?? '' }}">
                                </td>
                                <td id="grade-display-{{ $item->id }}">{{ grade($nilais->where('kategori_nilai_id', $item->id)->first()->nilai ?? 0) }}</td>
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
                        <td colspan="2" class="average-display">{{ number_format($nilais->sum('nilai') > 0 ? $nilais->sum('nilai') / $nilais->count() : 0, 2, '.', ',') }}</td>
                    </tr>
                    <tr>
                        <td colspan="2">Total Nilai Huruf</td>
                        <td colspan="2" class="average-grade-display">{{ grade($nilais->sum('nilai') > 0 ? $nilais->sum('nilai') / $nilais->count() : 0) }}</td>
                    </tr>
                </tfoot>
            </table>
            <div class="text-end mt-4">
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>

