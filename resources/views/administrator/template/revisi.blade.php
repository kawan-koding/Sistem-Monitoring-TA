<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title ?? ''}}</title>
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
            .page-break {
                page-break-after: always;
            }
        }

        .page-break {
            page-break-after: always;
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
            vertical-align: top;
        }

        .tag-name {
            margin: 100px 0 0 0;
        }

       .ttd-container {
            display: flex;               
            justify-content: flex-end;    
            margin-top: 20px;            
        }

        .ttd {
            justify-content: center;     
            margin: 0 50px;              
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
    @php $no = 1; @endphp
    @foreach ($rvs as $key => $data)

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
            <h5 style="font-weight: 800; text-align: center">FORMULIR REVISI PENGUJI {{ $data['judul']}} <br>
                PROGRAM STUDI TEKNOLOGI REKAYASA PERANGKAT LUNAK <br>
                POLITEKNIK NEGERI BANYUWANGI
            </h5>
            <table>
                <tr>
                    <td width="30%">Nama</td>
                    <td width="4%" style="text-align: center">:</td>
                    <td>{{ $jadwal->tugas_akhir->mahasiswa->nama_mhs }}</td>
                </tr>
                <tr>
                    <td>NIM/KELAS</td>
                    <td width="4%" style="text-align: center">:</td>
                    <td>{{ $jadwal->tugas_akhir->mahasiswa->nim }}/{{ $jadwal->tugas_akhir->mahasiswa->kelas }}</td>
                </tr>
                <tr>
                    <td>Nama Pembimbing</td>
                    <td width="4%" style="text-align: center">:</td>
                    <td>
                        @foreach ($bimbingUji as $index => $item)
                            {{ $index + 1 }}. {{ $item->dosen->name }}<br>
                        @endforeach
                    </td>
                </tr>
                <tr>
                    <td>Judul TA</td>
                    <td width="4%" style="text-align: center">:</td>
                    <td>{{ $jadwal->tugas_akhir->judul }}</td>
                </tr>
            </table>
        </div>
    </div>

    <div class="content-2">
        <table>
            <thead>
                <tr>
                    <th width="10%">NO</th>
                    <th width="70%">URAIAN PERBAIKAN</th>
                    <th width="20%">VALIDASI <br>(PARAF)</th>
                </tr>
            </thead>
            <tbody class="custom-body">
                <tr>
                    <td align="center"></td>
                    <td style="height: 320px">{!! isset($data['revisi']) ? $data['revisi']->catatan : '' !!}</td>
                    <td></td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="ttd-container" style="margin-left: 150px">
        <div class="ttd">
            <p style="margin: 5px 0;">Banyuwangi, {{ \Carbon\Carbon::parse($jadwal->tanggal)->locale('id')->translatedFormat('d F Y') }}</p>
            <p style="margin: 5px 0;">Dosen Penguji {{ toRoman($no++)}},</p>
            @if($data['revisi']->is_valid == true)
                <div class="check-circle-icon"></div>
            @endif
            <div class="footer-signature">
                <p class="{{ $data['revisi']->is_valid == false ? 'tag-name' : '' }}">({{ $data['dosen']->name ?? '' }})</p>
                <p style="margin: 5px 0;">NIP/NIK/NIPPPK. {{ $data['dosen']->nip ?? '' }}</p>
            </div>
        </div>
    </div>

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
