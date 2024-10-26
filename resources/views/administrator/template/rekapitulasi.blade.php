<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
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
            display: flex;
            justify-content: space-between;
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
                <h5 style="font-weight: 800; text-align: center">REKAPITULASI NILAI AKHIR SEMINAR PROPOSAL</h5>
            <button id="print" class="no-print">Cetak</button>
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
                <td>Program Studi</td>
                <td>:</td>
                <td>Teknologi Rekayasa Perangkat Lunak</td>
            </tr>
            <tr>
                <td>Judul TA</td>
                <td>:</td>
                <td>Pengembangan Frontend dan Backend Aplikasi Surat Disposisi Berbasis Web Menggunakan Framework Laravel di Universitas 17 Agustus 1945 Banyuwangi</td>
            </tr>
            <tr>
                <td>Dosen Pembimbing I</td>
                <td>:</td>
                <td>Dianni Yusuf, S.Kom., M.Kom. </td>
            </tr>
            <tr>
                <td>Dosen Pembimbing II</td>
                <td>:</td>
                <td>Khoirul Umam, S.Pdm., M.Kom.</td>
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
                <tr>
                    <td>1.</td>
                    <td>Pembimbing I</td>
                    <td align="center">90</td>
                    <td>30% X 90 = 24.6</td>
                </tr>
                <tr>
                    <td >2.</td>
                    <td>Pembimbing II</td>
                    <td align="center">100</td>
                    <td >30% X 100 = 30</td>
                </tr>
                <tr>
                    <td >3.</td>
                    <td>Penguji I</td>
                    <td align="center">100</td>
                    <td>20% X 100 = 20</td>
                </tr>
                <tr>
                    <td >4.</td>
                    <td>Penguji II</td>
                    <td align="center">100</td>
                    <td>20% X 100 = 20</td>
                </tr>
                <tr>
                    <td colspan="3" align="center"><strong>JUMLAH</strong></td>
                    <td align="center"></td>
                </tr>
                <tr>
                    <td colspan="3" align="center"><strong>Nilai Angka</strong></td>
                    <td align="center">82</td>
                </tr>
                <tr>
                    <td colspan="3" align="center"><strong>Nilai Huruf</strong></td>
                    <td align="center">AB</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="criteria">
        <div class="criteria-container">
            <div class="criteria-left">
                <p style="margin: 5px 0;">Mengetahui,</p>
                <p style="margin: 5px 0;">Ketua Program Studi</p>
                <p style="margin: 5px 0;">Teknologi Rekayasa Perangkat Lunak,</p>
                <div class="footer-signature">
                    <p class="tag-name">(Khoirul Umam, S.Pd., M.Kom.)</p>
                    <p style="margin: 5px 0;">NIP. 199103112022031006</p>
                </div>
            </div>
            <div class="criteria-right">
                <p style="margin: 5px 0;">Banyuwangi, 04 Desember 2024</p>
                <p style="margin: 5px 0;">Dosen Pembimbing,</p>
                <div class="footer-signature">
                    <p class="tag-name-2">(Khoirul Umam, S.Pd., M.Kom.)</p>
                    <p style="margin: 5px 0;">NIP. 199103112022031006</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('print').addEventListener('click', function() {
            window.print();
        });
    </script>
</body>
</html>
