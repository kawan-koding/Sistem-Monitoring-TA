
@foreach ($nilai as $item)
<div style="page-break-inside: avoid;">
{{-- Header --}}
<table width="100%">
    <tr>
        <td width="10%">
            <img src="{{ public_path("images/") }}/POLIWANGI.png" width="50px" alt="">
        </td>
        <td><h5>KEMENTERIAN RISET, TEKNOLOGI, DAN PENDIDIKAN TINGGI POLITEKNIK NEGERI BANYUWANGI</h5></td>
        <td width="20%"></td>
    </tr>
</table>
<table width="100%">
    <tr>
        <td width="60%"></td>
        <td width="">
            Kode Dokumen
        </td>
        <td width="3%">:</td>
        <td>FR-PRS-040</td>
    </tr>
    <tr>
        <td width="60%"></td>
        <td>
            Revisi
        </td>
        <td width="3%">:</td>
        <td>3</td>
    </tr>
</table>
<center><h3>LEMBAR PENILAIAN SEMINAR PROPOSAL TA</h3></center>
<table width="100%">
    <tr>
        <td width="25%">Nama Mahasiswa</td>
        <td width="3%">:</td>
        <td>{{$ta->mahasiswa->nama_mhs}}</td>
    </tr>
    <tr>
        <td width="25%">NIM</td>
        <td width="3%">:</td>
        <td>{{$ta->mahasiswa->nim}}</td>
    </tr>
    <tr>
        <td width="25%">Judul TA</td>
        <td width="3%">:</td>
        <td>{{$ta->judul}}</td>
    </tr>
    <tr>
        <td width="25%">Waktu Pengerjaan TA</td>
        <td width="3%">:</td>
        <td>Januari s/d Juni 2024</td>
    </tr>
    <tr >
        <td width="25%" style="vertical-align: top;">Nama Pembimbing</td>
        <td width="3%" style="vertical-align: top;">:</td>
        <td style="vertical-align: top;">
            <ol style="margin-left:-17px; margin-top:-2px;">
                @foreach ($nilai as $pmb)
                @if ($pmb->jenis == 'pembimbing')
                <li>{{$pmb->dosen->name}}</li>
                @endif
                @endforeach
            </ol>
        </td>
    </tr>
</table>

<table width="100%" border="2px" style="border-collapse: collapse;">
    <thead>
        <tr>
            <th>No</th>
            <th>AKTIVITAS YANG DINILAI</th>
            <th>NILAI ANGKA</th>
            <th>NILAI HURUF</th>
        </tr>
    </thead>
    <tbody>
        @php
            $detailNilai = \App\Models\DetailNilai::with(['nilai'])->where('nilai_id', $item->id)->whereHas('nilai', function($q)use($item){
                $q->where('dosen_id', $item->dosen_id);
            })->get();
            $jum = 0;
            $tot = 0;
        @endphp
        @foreach ($detailNilai as $key)
        @php
            $jum += $key->angka;
            $tot += 1;
        @endphp
        <tr>
            <td>{{$loop->iteration}}</td>
            <td>{{$key->aspek}}</td>
            <td style="text-align: center;">{{$key->angka}}</td>
            <td style="text-align: center;">{{$key->huruf}}</td>
        </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <th colspan="2">JUMLAH</th>
            <th>{{$jum}}</th>
            <th></th>
        </tr>
        <tr>
            @php
                $l = ($tot == 0 ? '0' : $jum/$tot);
                if($l >= 80){
                $nHuruf = 'A';
            }else if($l >= 75){
                $nHuruf = 'AB';
            }else if($l >= 65){
                $nHuruf = 'B';
            }else if($l >= 60){
                $nHuruf = 'BC';
            }else if($l >= 55){
                $nHuruf = 'C';
            }else if($l >= 40){
                $nHuruf = 'D';
            }else if($l < 40){
                $nHuruf = 'E';
            }
            @endphp
            <th colspan="2">RATA-RATA</th>
            <th>{{$l}}</th>
            <th>{{$nHuruf}}</th>
        </tr>
    </tfoot>
</table>
<p><i><b>Kriteria Penilaian :</b></i></p>
<table width="100%">
    <tr>
        <td>
            <table>
                <tr>
                    <td>>80 - 100</td>
                    <td>:</td>
                    <td>Huruf Mutu (A)</td>
                </tr>
                <tr>
                    <td>>75 - 80</td>
                    <td>:</td>
                    <td>Huruf Mutu (AB)</td>
                </tr>
                <tr>
                    <td>>65 - 75</td>
                    <td>:</td>
                    <td>Huruf Mutu (B)</td>
                </tr>
                <tr>
                    <td>>60 - 65</td>
                    <td>:</td>
                    <td>Huruf Mutu (BC)</td>
                </tr>
                <tr>
                    <td>>55 - 60</td>
                    <td>:</td>
                    <td>Huruf Mutu (C)</td>
                </tr>
                <tr>
                    <td>>40 - 55</td>
                    <td>:</td>
                    <td>Huruf Mutu (D)</td>
                </tr>
                <tr>
                    {{-- <td> &#8804; 40</td> --}}
                    <td> &lt; 40</td>
                    <td>:</td>
                    <td>Huruf Mutu (E)</td>
                </tr>
            </table>
            <span>*) Coret sesuai dengan kegiatan</span>
        </td>
        <td>
            Dosen Penguji
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <b><u>({{$item->dosen->name}})</u></b><br>
            <b>NIP. {{$item->dosen->nip}}</b>
        </td>
    </tr>
</table>

</div>
@endforeach
