<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Lembar Penilaian {{ $judul ?? '-' }}</title>
    <style>
        @media print {
            @page {
                size: A4;
            }

            body {
                margin: 0 2cm !important;
                padding: 0;
                font-size: 11pt;
            }

            .no-print {
                display: none;
            }

            .page-break {
                page-break-after: always;
            }
        }

        .page-break {
            page-break-after: always;
        }

        body {
            font-family: 'Times New Roman', Times, serif, ;
            margin: 0 2cm;
            padding: 0;
            overflow-x: hidden;
            /* Menghindari scrollbar horizontal */
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

        .content-2 table {
            width: 100%;
            border-collapse: collapse;
        }

        .content-2 table,
        .content-2 th,
        .content-2 td {
            border: 1px solid black;
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
            width: 45%;
        }

        .criteria-right {
            width: 55%;
        }

        .tag-name {
            margin: 100px 0 0 0;
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

            table,
            .content,
            .content-2,
            .criteria-container {
                font-size: 0.8em;
                /* Mengurangi ukuran font di tabel */
            }

            .tag-name {
                margin: 50px 0 0 0;
            }
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

    </style>
</head>

<body>
    @foreach ($nilai as $key => $item)
        <table>
            <tbody>
                <tr>
                    <td width="15%" class="header-logo">
                        <img src="{{ public_path('storage/images/settings/' . getSetting('app_logo')) }}"
                            alt="Poliwangi Logo">
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
                <h5 style="font-weight: 800; text-align: center">LEMBAR PENILAIAN  {{ $item['tipe'] }}</h5>
                {{-- @if ($loop->first)
                <button id="print" class="no-print">Cetak</button>
            @endif --}}
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
                        <td>Judul TA</td>
                        <td>:</td>
                        <td>{{ $jadwal->tugas_akhir->judul }}</td>
                    </tr>
                    <tr>
                        <td>Waktu Pengerjaan TA</td>
                        <td>:</td>
                        <td>-</td>
                    </tr>
                    <tr>
                        <td>Nama Pembimbing</td>
                        <td>:</td>
                    </tr>
                </table>
                <ol style="margin: 0px -20px">
                    @foreach ($bimbingUji as $dsn)
                        <li style="margin: 5px 0">{{ $dsn->dosen->name }}</li>
                    @endforeach
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
                    @if (!empty($item['nilai']) && count($item['nilai']) > 0)
                        @foreach ($item['nilai'] as $index => $nilai)
                            <tr>
                                <td align="center">{{ $index + 1 }}</td>
                                <td>{{ $nilai['kategori_nilai'] }}</td>
                                <td align="center">{{ $nilai['nilai'] }}</td>
                                <td align="center">{{ $nilai['nilai_huruf'] }}</td>
                            </tr>
                        @endforeach
                    @else
                        @foreach ($kategoriNilai as $index => $kategori)
                            <tr>
                                <td align="center">{{ $index + 1 }}</td>
                                <td>{{ $kategori->nama }}</td>
                                <td align="center">0</td>
                                <td align="center">0</td>
                            </tr>
                        @endforeach
                    @endif
                    <tr>
                        <td colspan="2" align="center"><strong>JUMLAH</strong></td>
                        <td align="center"></td>
                        <td align="center"></td>
                    </tr>
                    <tr>
                        <td colspan="2" align="center"><strong>RATA - RATA</strong></td>
                        <td align="center">{{ $item['totalNilaiAngka'] }}</td>
                        <td align="center">{{ $item['totalNilaiHuruf'] }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <table width="100%" class="criteria-container">
            <td class="criteria-left">
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
                        <td>
                            < 40</td>
                        <td>: Huruf Mutu (E)</td>
                    </tr>
                </table>
            </td>
            <td class="criteria-right">
                <p>Dosen {{ $item['peran'] }},</p>
                @if (!empty($item['nilai']) && count($item['nilai']) > 0)
                <div class="check-circle-icon"></div>
                @endif
                <div class="footer-signature">
                    <p class="{{ !empty($item['nilai']) && count($item['nilai']) > 0 ? '' : 'tag-name' }}">({{ $item['dosen']->name }})</p>
                    <p style="margin: 5px 0;">NIP/NIK/NIPPPK. {{ $item['dosen']->nip }}</p>
                </div>
            </td>
        </table>
        {{-- </div>
        </div> --}}
        {{-- <hr class="no-print"> --}}
        @if (!$loop->last)
            <div class="page-break"></div>
        @endif
    @endforeach

    {{-- <script>
        document.getElementById('print').addEventListener('click', function() {
            window.print();
        });
    </script> --}}
</body>

</html>
