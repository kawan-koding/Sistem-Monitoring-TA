<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    
    <h1>Selamat {{ $mahasiswa->nama_mhs }},</h1>
    
    <p>Anda telah disetujui untuk topik berikut:</p>

    <ul>
        <li><strong>Judul Topik:</strong> {{ $rekomendasiTopik->judul }}</li>
        <li><strong>Dosen Pembimbing:</strong> {{ $rekomendasiTopik->dosen->name }}</li>
    </ul>

    <p>Silakan hubungi dosen pembimbing Anda untuk langkah selanjutnya.</p>

    <p>Terima kasih,</p>
    <p>Tim Rekomendasi Topik</p>
</body>
</html>

