{{-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" href="{{ asset('storage/images/settings/' . getSetting('app_favicon')) }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title ?? 'Lembar Penilaian'}}</title>
    <style>
        @media print {
            @page {
                size: A4;
                /* margin: 2cm; */
            }

            body {
                margin: 0;
                padding: 0;
                font-size: 12pt;
                width: 100%;
            }
            .no-print {
                display: none;
            }
        }

        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 12pt;
        }

        table {
            width: 100%;
            max-width: 910px;
            margin: 0 auto;
            border-collapse: collapse;
            border: 1px solid #000;
        }

        td {
            padding: 10px;
            vertical-align: middle;
        }

        .header-logo img {
            height: 2cm;
            width: 2cm;
        }

        .header-title {
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
        .centered {
            text-align: center;
        }
    </style>
</head>
<body>
    <table cellpadding="0" cellspacing="0">
        <tbody>
            <tr>
                <td width="15%" class="header-logo">
                    <img src="{{ asset('storage/images/settings/' . getSetting('app_logo')) }}" alt="Poliwangi Logo">
                </td>
                <td width="85%" class="header-title">
                    <strong>KEMENTERIAN RISET, TEKNOLOGI DAN PENDIDIKAN TINGGI</strong>
                    POLITEKNIK NEGERI BANYUWANGI
                </td>
            </tr>
            <tr>
                <td style="text-align: right" colspan="2">
                    <div style="display: inline-block; text-align: right;">
                        <div>Kode Dokumen :</div>
                        <div>Revisi :</div>
                    </div>
                </td>
            </tr>
            <tr>
                <td class="centered" colspan="2">
                    <strong>LEMBAR PENILAIAN SIDANG AKHIR</strong>
                </td>
            </tr>
            <tr>
                <td width="30%">Nama Mahasiswa </td>
                <td width="5%">:</td>
                <td width="65%">Rikiansyah Aris Kurniawan</td>
            </tr>
            <tr>
                <td>NIM </td>
                <td>:</td>
                <td>362055401016</td>
            </tr>
            <tr>
                <td>Judul TA </td>
                <td>:</td>
                <td>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Voluptatem reiciendis aspernatur, alias delectus suscipit autem obcaecati veritatis? Autem iure tempora, enim voluptatem fuga perferendis obcaecati, vero ut animi, recusandae nulla.</td>
            </tr>
            <tr>
                <td>Nama Pembimbing </td>
                <td>:</td>
                <td></td>
            </tr>
            <tr>
                <td>
                    <ol>
                        <li>-</li>
                        <li>-</li>
                    </ol>
                </td>
            </tr>
        </tbody>
    </table>
</body>
</html> --}}

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Lembar Penilaian Seminar Proposal</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20mm;
            padding: 0;
        }

        .header {
            text-align: center;
        }

        .header img {
            width: 100px;
        }

        .header h1 {
            margin: 0;
            font-size: 16pt;
        }

        .header p {
            margin: 0;
            font-size: 12pt;
        }

        .document-info {
            margin-top: 20px;
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
            margin-top: 30px;
        }

        .content table {
            width: 100%;
            border-collapse: collapse;
        }

        .content td {
            padding: 5px;
            vertical-align: top;
        }

        .content table, .content th, .content td {
            border: 1px solid black;
        }

        .content th {
            background-color: #f2f2f2;
            text-align: center;
        }

        .criteria {
            margin-top: 30px;
        }

        .criteria table {
            width: 100%;
        }

        .criteria td {
            padding: 5px;
        }

        .footer {
            margin-top: 50px;
            text-align: right;
        }

        .footer-signature {
            text-align: center;
            margin-top: 60px;
        }

    </style>
</head>
<body>
    <div class="header">
        <img src="{{ asset('storage/images/settings/' . getSetting('app_logo')) }}" alt="Poliwangi Logo">
        <h1>KEMENTERIAN PENDIDIKAN KEBUDAYAAN, RISET, DAN TEKNOLOGI</h1>
        <p>POLITEKNIK NEGERI BANYUWANGI</p>
    </div>

    <div class="document-info">
        <table>
            <tr>
                <td>Kode Dokumen</td>
                <td>:</td>
                <td>FR–PRS-040</td>
            </tr>
            <tr>
                <td>Revisi</td>
                <td>:</td>
                <td>3</td>
            </tr>
        </table>
    </div>

    <div class="content">
        <h2>LEMBAR PENILAIAN SEMINAR PROPOSAL</h2>
        <table>
            <tr>
                <td><strong>Nama Mahasiswa</strong></td>
                <td>Rikiansyah Aris Kurniawan</td>
            </tr>
            <tr>
                <td><strong>NIM</strong></td>
                <td>362055401016</td>
            </tr>
            <tr>
                <td><strong>Judul TA</strong></td>
                <td>Pengembangan Frontend dan Backend Aplikasi Surat Disposisi Berbasis Web Menggunakan Framework Laravel di Universitas 17 Agustus 1945 Banyuwangi</td>
            </tr>
            <tr>
                <td><strong>Waktu Pengerjaan TA</strong></td>
                <td>Februari s/d Juni</td>
            </tr>
            <tr>
                <td><strong>Nama Pembimbing</strong></td>
                <td>1. Dianni Yusuf, S.Kom., M.Kom.<br>2. Khoirul Umam, S.Pd, M.Kom.</td>
            </tr>
        </table>
    </div>

    <div class="content">
        <table>
            <thead>
                <tr>
                    <th>NO</th>
                    <th>AKTIVITAS YANG DINILAI</th>
                    <th>NILAI ANGKA</th>
                    <th>NILAI HURUF</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1.</td>
                    <td>Penguasaan Materi</td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>2.</td>
                    <td>Tinjauan Pustaka</td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>3.</td>
                    <td>Ketepatan Menjawab Pertanyaan</td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>4.</td>
                    <td>Kedalaman Materi</td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>5.</td>
                    <td>Etika</td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>6.</td>
                    <td>Kedisiplinan</td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="3" align="right"><strong>JUMLAH</strong></td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="3" align="right"><strong>RATA - RATA</strong></td>
                    <td></td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="criteria">
        <p>Kriteria Penilaian:</p>
        <table>
            <tr>
                <td>80 – 100</td>
                <td>: Huruf Mutu (A)</td>
            </tr>
            <tr>
                <td>75 – 80</td>
                <td>: Huruf Mutu (AB)</td>
            </tr>
            <tr>
                <td>65 – 75</td>
                <td>: Huruf Mutu (B)</td>
            </tr>
            <tr>
                <td>60 – 65</td>
                <td>: Huruf Mutu (BC)</td>
            </tr>
            <tr>
                <td>55 – 60</td>
                <td>: Huruf Mutu (C)</td>
            </tr>
            <tr>
                <td>40 – 55</td>
                <td>: Huruf Mutu (D)</td>
            </tr>
            <tr>
                <td>< 40</td>
                <td>: Huruf Mutu (E)</td>
            </tr>
        </table>
    </div>

    <div class="footer">
        <p>Dosen Pembimbing II,</p>
        <div class="footer-signature">
            <p>(Khoirul Umam, S.Pd., M.Kom.)</p>
            <p>NIP. 199103112022031006</p>
        </div>
    </div>
</body>
</html>
