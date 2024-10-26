<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Lembar Penilaian Seminar Proposal</title>
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
        }

        .content-2 td {
            padding: 5px;
        }

        .criteria-container {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        .criteria-left {
            width: 50%;
        }

        .criteria-right {
            width: 50%;
            text-align: center;
        }
        
    </style>
</head>
<body>
    <table>
        <tbody>
            <tr>
                <td width="15%" class="header-logo">
                    <img src="{{ asset('storage/images/settings/' . getSetting('app_logo')) }}" alt="Poliwangi Logo">
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
                    <td>FR–PRS-040</td>
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
            <h5 style="font-weight: 800; text-align: center">LEMBAR PENILAIAN SEMINAR PROPOSAL</h5>
            <table>
            <tr>
                <td width="30%">Nama Mahasiswa</td>
                <td>:</td>
                <td>Rikiansyah Aris Kurniawan</td>
            </tr>
            <tr>
                <td>NIM</td>
                <td>:</td>
                <td>362055401016</td>
            </tr>
            <tr>
                <td>Judul TA</td>
                <td>:</td>
                <td>Pengembangan Frontend dan Backend Aplikasi Surat Disposisi Berbasis Web Menggunakan Framework Laravel di Universitas 17 Agustus 1945 Banyuwangi</td>
            </tr>
            <tr>
                <td>Waktu Pengerjaan TA</td>
                <td>:</td>
                <td>Februari s/d Juni</td>
            </tr>
            <tr>
                <td>Nama Pembimbing</td>
                <td>:</td>
            </tr>
        </table>
        <ol style="margin: 0px -20px">
            <li style="margin: 5px 0">Dianni Yusuf, S.Kom., M.Kom.</li>
            <li>Khoirul Umam, S.Pdm, M.Kom.</li>
        </ol>
        </div>
    </div>

    <div class="content-2">
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
                    <td align="center">1.</td>
                    <td>Penguasaan Materi</td>
                    <td align="center">90</td>
                    <td align="center">80</td>
                </tr>
                <tr>
                    <td align="center">2.</td>
                    <td>Tinjauan Pustaka</td>
                    <td align="center">100</td>
                    <td align="center">80</td>
                </tr>
                <tr>
                    <td align="center">3.</td>
                    <td>Ketepatan Menjawab Pertanyaan</td>
                    <td align="center">80</td>
                    <td align="center">82</td>
                </tr>
                <tr>
                    <td align="center">4.</td>
                    <td>Kedalaman Materi</td>
                    <td align="center">56</td>
                    <td align="center">78</td>
                </tr>
                <tr>
                    <td align="center">5.</td>
                    <td>Etika</td>
                    <td align="center">98</td>
                    <td align="center">98</td>
                </tr>
                <tr>
                    <td align="center">6.</td>
                    <td>Kedisiplinan</td>
                    <td align="center">56</td>
                    <td align="center">90</td>
                </tr>
                <tr>
                    <td colspan="2" align="center"><strong>JUMLAH</strong></td>
                    <td align="center">78</td>
                    <td align="center">67</td>
                </tr>
                <tr>
                    <td colspan="2" align="center"><strong>RATA - RATA</strong></td>
                    <td align="center">82</td>
                    <td align="center">A</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="criteria">
        <div class="criteria-container">
            <div class="criteria-left">
                <p style="font-weight: 800;margin: 0"><i>Kriteria Penilaian:</i></p>
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
            <div class="criteria-right">
                <p>Dosen Pembimbing II,</p>
                <div class="footer-signature">
                    <p style="margin: 100px 0px 0px 0px">(Khoirul Umam, S.Pd., M.Kom.)</p>
                    <p style="margin: 0">NIP. 199103112022031006</p>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
