@extends('layout.admin-main')
@section('content')

<div class="row">
    <div class="col-md-12 col-sm-12 col-g-12">
        <div class="card">
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="mdi mdi-check-all me-2"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="mdi mdi-block-helper me-2"></i>{{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <form action="" method="get">
                    <div class="row">
                        @csrf
                        <div class="col-lg-4 mb-3">
                            <label for="">Status</label>
                            <select name="status_ta" class="form-control" id="status_ta">
                                <option value=""></option>
                                <option value="1">Belum ACC</option>
                                <option value="2">ACC Kaprodi</option>
                                <option value="3">Telah Dijadwalkan</option>
                                <option value="4">Belum Dijadwalkan</option>
                            </select>
                        </div>
                        <div class="col-lg-2 mb-3">
                            <div class="text-start mt-2">
                                <br>
                                <button type="submit" class="btn btn-sm btn-primary mt-1">Filter</button>
                                <button type="button" onclick="printDiv('cetakPage')" class="btn btn-sm btn-primary mt-1">PDF</button>
                                <button type="button" onclick="exportToExcel('tableku')" class="btn btn-sm btn-primary mt-1">Excel</button>
                            </div>
                        </div>
                    </div>
                </form>
                <div id="cetakPage">
                    <table class="table table-striped" id="tableku">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Judul</th>
                                <th>Mahasiswa</th>
                                <th>Jenis</th>
                                <th>Topik</th>
                                <th>Status</th>
                                <th>Dosen</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($dataTa as $item)
                                @php
                                    $item_pemb_1 = null;
                                    $item_peng_1 = null;
                                    $item_pemb_2 = null;
                                    $item_peng_2 = null;
                                @endphp
                                @foreach ($item->bimbing_uji as $bimuj)
                                    @if ($bimuj->jenis == 'pembimbing' && $bimuj->urut == 1)
                                        @php
                                            $item_pemb_1 = $bimuj->dosen->name;
                                        @endphp
                                    @endif
                                    @if ($bimuj->jenis == 'pembimbing' && $bimuj->urut == 2)
                                        @php
                                            $item_pemb_2 = $bimuj->dosen->name;
                                        @endphp
                                    @endif
                                    @if ($bimuj->jenis == 'penguji' && $bimuj->urut == 1)
                                        @php
                                            $item_peng_1 = $bimuj->dosen->name;
                                        @endphp
                                    @endif
                                    @if ($bimuj->jenis == 'penguji' && $bimuj->urut == 2)
                                        @php
                                            $item_peng_2 = $bimuj->dosen->name;
                                        @endphp
                                    @endif
                                @endforeach
                                @php
                                    $jadwal_sem = \App\Models\JadwalSeminar::where('tugas_akhir_id', $item->id)->first();
                                @endphp
                                @if (!isset($jadwal_sem) && $telahJadwal == 0)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$item->judul}}</td>
                                    <td>{{$item->mahasiswa->nama_mhs}}</td>
                                    <td>{{$item->jenis_ta->nama_jenis}}</td>
                                    <td>{{$item->topik->nama_topik}}</td>
                                    <td>
                                        @if (isset($jadwal_sem))
                                            <span class="badge bg-primary">Sudah Terjadwal</span>
                                        @else
                                            <span class="badge bg-secondary">Belum Terjadwal</span>
                                        @endif
                                    </td>
                                    <td>
                                        Pembimbing 1 : {{$item_pemb_1 ?? '-'}}<br>
                                        Pembimbing 2 : {{$item_pemb_2 ?? '-'}}<br>
                                        Penguji 1 : {{$item_peng_1 ?? '-'}}<br>
                                        Penguji 2 : {{$item_peng_2 ?? '-'}}<br>
                                    </td>
                                </tr>
                                @endif
                                @if (isset($jadwal_sem) && $telahJadwal == 1)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$item->judul}}</td>
                                    <td>{{$item->mahasiswa->nama_mhs}}</td>
                                    <td>{{$item->jenis_ta->nama_jenis}}</td>
                                    <td>{{$item->topik->nama_topik}}</td>
                                    <td>
                                        @if (isset($jadwal_sem))
                                            <span class="badge bg-primary">Sudah Terjadwal</span>
                                        @else
                                            <span class="badge bg-secondary">Belum Terjadwal</span>
                                        @endif
                                    </td>
                                    <td>
                                        Pembimbing 1 : {{$item_pemb_1 ?? '-'}}<br>
                                        Pembimbing 2 : {{$item_pemb_2 ?? '-'}}<br>
                                        Penguji 1 : {{$item_peng_1 ?? '-'}}<br>
                                        Penguji 2 : {{$item_peng_2 ?? '-'}}<br>
                                    </td>
                                </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.4/xlsx.full.min.js"></script>
<script>
    function printDiv(divId) {
        console.log('printDiv called with:', divId);
        var printWindow = window.open('', '', 'height=600,width=800');
        var divContents = document.getElementById(divId).innerHTML;
        console.log('divContents:', divContents);
        var styles = '<style>table { width: 100%; border-collapse: collapse; } th, td { border: 1px solid black; padding: 8px; } th { background-color: #f2f2f2; }</style>';
        printWindow.document.write('<html><head><title>Print</title>' + styles + '</head><body>');
        printWindow.document.write(divContents);
        printWindow.document.write('</body></html>');
        printWindow.document.close();
        printWindow.focus();
        printWindow.print();
    }
    function exportToExcel(tableId, filename = 'data.xlsx') {
        var table = document.getElementById(tableId);
        var wb = XLSX.utils.table_to_book(table, { sheet: "Sheet1" });
        XLSX.writeFile(wb, filename);
    }
</script>

@endsection
