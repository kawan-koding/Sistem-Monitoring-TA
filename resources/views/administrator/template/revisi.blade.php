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
            overflow-x: hidden;
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
        .content table, .content th, .content td {
            border: 1px solid black;
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

        .tag-name {
            margin: 100px 0 0 0;
        }

       .ttd-container {
            display: flex;                /* Menggunakan flexbox */
            justify-content: flex-end;    /* Menempatkan elemen ke sisi kanan */
            margin-top: 20px;            /* Spasi atas */
        }

        .ttd {
            justify-content: center;      /* Memposisikan elemen di tengah secara vertikal */
            margin: 0 50px;                /* Mengatur margin otomatis untuk memusatkan */
        }

        .custom-body {
            height: 350px;
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
            .custom-body {
                height: 250px;
            }

            .document-info table {
                font-size: 6px;
            }

            table, .content, .content-2, .criteria-container {
                font-size: 0.8em;
            }

            .tag-name {
                margin: 50px 0 0 0;
            }

            .ttd-container {
                font-size: 8px;
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
                    <td>FR–PRS-046</td>
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
            <h5 style="font-weight: 800; text-align: center">FORMULIR REVISI PENGUJI SEMINAR PROPOSAL <br>
                PROGRAM STUDI TEKNOLOGI REKAYASA PERANGKAT LUNAK <br>
                POLITEKNIK NEGERI BANYUWANGI
            </h5>
            <button id="print" class="no-print">Cetak</button>
            <table>
                <tr>
                    <td width="30%">Nama</td>
                    <td>:</td>
                    <td>Rikiansyah Aris Kurniawan</td>
                </tr>
                <tr>
                    <td>NIM/KELAS</td>
                    <td>:</td>
                    <td>362055401016/4A</td>
                </tr>
                <tr>
                    <td>Nama Pembimbing</td>
                    <td>:</td>
                    <td>1. Dianni Yusuf, S.Kom., M.Kom. <br> 2. Khoirul Umam, S.Pdm, M.Kom. </td>
                </tr>
                <tr>
                    <td>Judul TA</td>
                    <td>:</td>
                    <td>Pengembangan Frontend dan Backend Aplikasi Surat Disposisi Berbasis Web Menggunakan Framework Laravel di Universitas 17 Agustus 1945 Banyuwangi</td>
                </tr>
            </table>
        </div>
    </div>

    <div class="content-2">
        <table>
            <tbody>
               <thead>
                    <tr>
                        <th width="10%">NO</th>
                        <th width="70%">URAIAN PERBAIKAN</th>
                        <th width="20%">VALIDASI <br>(PARAF)</th>
                    </tr>
                </thead>
                <tbody class="custom-body">
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                </tbody>
            </tbody>
        </table>
    </div>
    <div class="ttd-container">
        <div class="ttd">
            <p style="margin: 5px 0;">Banyuwangi, 10 Desember 2024</p>
            <p style="margin: 5px 0;">Dosen Penguji I,</p>
            <div class="footer-signature">
                <p class="tag-name">(Khoirul Umam, S.Pd., M.Kom.)</p>
                <p style="margin: 5px 0;">NIP. 199103112022031006</p>
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
