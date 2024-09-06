<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>

@foreach ($revisi as $item)
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
        <td>FR-PRS-046</td>
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
<br><br>
<center><h3>FORMULIR REVISI PENGUJI SEMINAR PROPOSAL TA</h3></center>
<table width="100%" border="2" style="border-collapse: collapse">
    <tr>
        <td width="25%">NAMA</td>
        <td>{{$ta->mahasiswa->nama_mhs}}</td>
    </tr>
    <tr>
        <td width="25%">NIM/KELAS</td>
        <td>{{$ta->mahasiswa->nim}} / {{$ta->mahasiswa->kelas}}</td>
    </tr>
    <tr >
        <td width="25%" rowspan="2">DOSEN PEMBIMBING</td>
        <td>
            {{$pembimbing->dosen->name}}
        </td>
    </tr>
    <tr >

        <td>
            {{$pembimbing2->dosen->name}}
        </td>
    </tr>
    <tr>
        <td width="25%">JUDUL TA</td>
        <td>{{$ta->judul}}</td>
    </tr>
</table>
<br>
<table width="100%" border="1px" style="border-collapse: collapse;">
    <thead>
        <tr>
            <th>No</th>
            <th>URAIAN PERBAIKAN</th>
            <th>VALIDASI</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($item->uraian_revisi as $key)
        <tr>
            <td style="border-bottom: 1px solid white;">{{$loop->iteration}}</td>
            <td style="border-bottom: 1px solid white;">{{$key->uraian}}</td>
            <td style="border-bottom: 1px solid white;"></td>
        </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td height="50px"></td>
            <td></td>
            <td></td>
        </tr>

    </tfoot>
</table>
<span>*) coret sesuai kegiatan</span><br><br><br>
<table width="100%">
    <tr>
        <td width="50%"></td>
        <td width="50%">Banyuwangi, {{$tanggal}}</td>
    </tr>
    <tr>
        <td width="50%">
        </td>
        <td width="50%">
            <span>Dosen Penguji</span>
        </td>
    </tr>
    <tr>
        <td width="50%">
            <br><br><br><br><br><br>
        </td>
        <td width="50%">
            <br><br><br><br><br><br>
        </td>
    </tr>
    <tr>
        <td width="50%">
        </td>
        <td width="50%">
                    <span>( <u>{{$item->dosen->name}}</u> )</span>
                    <br>
                    <span>NIP. {{$item->dosen->nip}}</span>
        </td>
    </tr>
</table>

</div>
@endforeach

</body>
</html>
