<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Rekapitulasi Nilai {{ $tipe ?? '' }}</title>
    <style>
        @media print {
            @page {
                size: A4;
            }
            body {
                margin: 0 2cm !important;
                padding: 0;
                font-size: 12pt;
            }
            .no-print {
                display: none;
            }
        }
        body {
            font-family: 'Times New Roman', Times, serif,;
            margin: 0 2cm;
            padding: 0;
            overflow-x: hidden; /* Menghindari scrollbar horizontal */
        }
        
        .header-logo img {
            height: 1cm;
            width: 1cm;
        }

        .header-title {
            font-size: 10px;
            text-align: left;
            font-weight: bold;
        }

        .header-title strong {
            display: block;
            margin-bottom: 5px;
        }

        .header-title span {
            font-size: 14px;
        }

        .document-info {
            text-align: right;
        }

        .document-info table {
            float: right;
            text-align: left;
        }

        .document-info td {
            padding: 2px 5px;
        }

        .content {
            margin-top: 70px;
        }


        .content table {
            width: 100%;
            border-collapse: collapse;
        }

        .content td {
            padding: 5px;
            vertical-align: top;
        }

        .content th {
            background-color: #f2f2f2;
        }

        .content-2 {
            margin-top: 30px;
        }

        .content-2  table {
            width: 100%;
            border-collapse: collapse;
        }
        .content-2 table, .content-2 th, .content-2 td {
            border: 1px solid black;
            padding: 5px;
        }

        .content-2 td {
            padding: 5px;
        }

        .criteria-container {
            /* display: flex;
            justify-content: space-between; */
            margin-top: 20px;
        }

        .criteria-left {
            width: 60%;
        }

        .criteria-right {
            width: 40%;
        }

        .tag-name {
            margin: 100px 0 0 0;
        }

        .tag-name-2 {
            margin: 118px 0 0 0;
        }

        .check-circle-icon {
            position: relative;
            left: 50px;
            width: 50px;
            height: 50px;
            border: 3px solid #007bff; 
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        .check-circle-icon::after {
            content: '';
            position: absolute;
            width: 20px;
            height: 8px;
            border: solid #007bff;
            border-width: 0 0 6px 6px;
            transform: rotate(-45deg);
            top: 38%;
            left: 42%;
            transform: translate(-50%, -50%) rotate(-45deg);
        }

        @media (max-width: 600px) {
            body {
                font-size: 0.8em;
                margin: 0 1cm;
                padding: 0;
            }

            .header-logo img {
                height: 0.5cm;
                width: 0.5cm;
            }

            .content {
                margin-top: 40px;
            }
            .header-title {
                font-size: 5px;
            }

            .document-info table {
                font-size: 6px;
            }

            table, .content, .content-2, .criteria-container {
                font-size: 0.8em; /* Mengurangi ukuran font di tabel */
            }

            .criteria-left {
                width: 55%;
            }

            .criteria-right {
                width: 45%;
            }

            .tag-name {
                margin: 50px 0 0 0;
            }

            .tag-name-2 {
               margin: 60px 0 0 0;
            }
        }
        
    </style>
</head>
<body>
    <table>
        <tbody>
            <tr>
                <td width="15%" class="header-logo">
                    <img src="{{ public_path('storage/images/settings/' . getSetting('app_logo')) }}" alt="Poliwangi Logo">
                </td>
                <td width="85%" class="header-title">
                    KEMENTERIAN RISET, TEKNOLOGI DAN PENDIDIKAN TINGGI <br>
                    POLITEKNIK NEGERI BANYUWANGI
                </td>
            </tr>
        </tbody>
    </table>

    <div class="document-info">
        <table>
            <tbody>
                <tr>
                    <td>Kode Dokumen</td>
                    <td>:</td>
                    <td>FR–PRS-042</td>
                </tr>
                <tr>
                    <td>Revisi</td>
                    <td>:</td>
                    <td>3</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="content">
        <div class="title">
                <h5 style="font-weight: 800; text-align: center">REKAPITULASI NILAI AKHIR {{ $tipe }}</h5>
            <table>
            <tr>
                <td width="30%">Nama Mahasiswa</td>
                <td width="2%">:</td>
                <td>{{ $jadwal->tugas_akhir->mahasiswa->nama_mhs }}</td>
            </tr>
            <tr>
                <td>NIM</td>
                <td>:</td>
                <td>{{ $jadwal->tugas_akhir->mahasiswa->nim }}</td>
            </tr>
            <tr>
                <td>Program Studi</td>
                <td>:</td>
                <td>{{ $jadwal->tugas_akhir->mahasiswa->programStudi->nama }}</td>
            </tr>
            <tr>
                <td>Judul TA</td>
                <td>:</td>
                <td>{{ $jadwal->tugas_akhir->judul }}</td>
            </tr>
            <tr>
                <td>Dosen Pembimbing I</td>
                <td>:</td>
                <td>{{ $pemb1->dosen->name }}</td>
            </tr>
            <tr>
                <td>Dosen Pembimbing II</td>
                <td>:</td>
                <td>{{ $pemb2->dosen->name }}</td>
            </tr>
        </table>
        </div>
    </div>

    <div class="content-2">
        <table>
            <thead>
                <tr>
                    <th>NO</th>
                    <th>PENILAI</th>
                    <th>NILAI</th>
                    <th>NILAI TERTIMBANG</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($rekap as $item)
                <tr>
                    <td align="center">{{ $loop->iteration }}</td>
                    <td>{{ $item['penilai'] }}</td>
                    <td align="center">{{ $item['nilai'] }}</td>
                    <td align="center">{{ $item['persentase'] }}</td>
                </tr>
                @endforeach
                <tr>
                    <td colspan="3" align="center"><strong>JUMLAH</strong></td>
                    <td align="center">{{ $jumlah }}</td>
                </tr>
                <tr>
                    <td colspan="3" align="center"><strong>Nilai Angka</strong></td>
                    <td align="center">{{ $nilai_angka }}</td>
                </tr>
                <tr>
                    <td colspan="3" align="center"><strong>Nilai Huruf</strong></td>
                    <td align="center">{{ $nilai_huruf }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <table class="criteria-container" width="105%" style="margin-left: -5px;">
        <td class="criteria-left">
            <p style="margin: 5px 0;">Mengetahui,</p>
            <p style="margin: 5px 0;">Ketua Program Studi</p>
            <p style="margin: 5px 0;">{{ $kaprodi->programStudi->nama ?? ''}},</p>
            <div class="check-circle-icon"></div>
            <div class="footer-signature">
                <p class="">({{ $kaprodi->name ?? '' }})</p>
                <p style="margin: 5px 0;">NIP/NIK/NIPPPK. {{ $kaprodi->nip ?? ''}}</p>
            </div>
        </td>
        <td class="criteria-right" style="white-space: nowrap">
            <p style="margin: 5px 0;">Banyuwangi, {{ \Carbon\Carbon::parse($jadwal->tanggal)->locale('id')->translatedFormat('d F Y') }}</p>
            <p style="margin: 5px 0;">Dosen Pembimbing,</p>
            <br><br>
            <div class="check-circle-icon"></div>
            <div class="footer-signature">
                <p class="">({{ $pemb1->dosen->name }})</p>
                <p style="margin: 5px 0;">NIP/NIK/NIPPPK. {{ $pemb1->dosen->nip }}</p>
            </div>
        </td>
    </table>
</body>
</html>
