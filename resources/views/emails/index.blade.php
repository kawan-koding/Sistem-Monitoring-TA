<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title></title>
</head>
<body>
<center><h3>Jadwal Seminar</h3></center>
@php
$to = $details['to'];
$ta = $details['ta'];
$seminar = $details['seminar'];

    
@endphp
<table>
    <tr>
        <td>Nama</td>
        <td>:</td>
        <td>{{$to['name']}}</td>
    </tr>
    <tr>
        <td>Sebagai</td>
        <td>:</td>
        <td>{{$to['sebagai']}}</td>
    </tr>
</table>
<hr>
<center><span>Anda memiliki jadwal seminar pada :</span></center>
<hr>
<table>
    <tr>
        <td>Tanggal</td>
        <td>:</td>
        <td>{{$seminar['tanggal']}}</td>
    </tr>
    <tr>
        <td>Jam Mulai</td>
        <td>:</td>
        <td>{{$seminar['jam_mulai']}}</td>
    </tr>
    <tr>
        <td>Jam Selesai</td>
        <td>:</td>
        <td>{{$seminar['jam_selesai']}}</td>
    </tr>
</table>
<hr>
<center>
    <span>Untuk pengujian TA yang berjudul :</span>
</center>
<hr>
<table>
    <tr>
        <td>Judul</td>
        <td>:</td>
        <td>{{$ta->judul}}</td>
    </tr>
    <tr>
        <td>Jenis</td>
        <td>:</td>
        <td>{{$ta->jenis_ta->nama_jenis}}</td>
    </tr>
    <tr>
        <td>topik</td>
        <td>:</td>
        <td>{{$ta->topik->nama_topik}}</td>
    </tr>
</table>
</body>
</html>