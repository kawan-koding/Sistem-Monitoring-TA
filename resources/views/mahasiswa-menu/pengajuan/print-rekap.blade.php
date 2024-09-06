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
            <td>FR-PRS-042</td>
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
    <center><h3>REKAPITULASI NILAI AKHIR SEMINAR PROPOSAL TA</h3></center>
    <table width="100%">
        <tr>
            <td width="25%">Nama Mahasiswa</td>
            <td width="3%">:</td>
            <td>{{$ta->mahasiswa->nama_mhs}}</td>
        </tr>
        <tr>
            <td width="25%">NIM</td>
            <td width="3%">:</td>
            <td>{{$ta->mahasiswa->nim}}</td>
        </tr>
        <tr>
            <td width="25%">Judul TA</td>
            <td width="3%">:</td>
            <td>{{$ta->judul}}</td>
        </tr>
        <tr>
            <td width="25%">Waktu Pengerjaan TA</td>
            <td width="3%">:</td>
            <td>Januari s/d Juni 2024</td>
        </tr>
        <tr>
            <td width="25%">Dosen Pembimbing I</td>
            <td width="3%">:</td>
            <td>
                @foreach ($nilai as $pmb)
                    @if ($pmb->jenis == 'pembimbing' && $pmb->urut == 1)
                        {{$pmb->dosen->name}}
                    @endif
                @endforeach
            </td>
        </tr>
        <tr>
            <td width="25%">Dosen Pembimbing II</td>
            <td width="3%">:</td>
            <td>
                @foreach ($nilai as $pmb)
                    @if ($pmb->jenis == 'pembimbing' && $pmb->urut == 2)
                        {{$pmb->dosen->name}}
                    @endif
                @endforeach
            </td>
        </tr>
    </table>

    <table width="100%" border="2" style="border-collapse: collapse;">
        <thead>
            <tr>
                <th>No</th>
                <th>PENILAI</th>
                <th>NILAI</th>
                <th>NILAI TERTIMBANG</th>
            </tr>
        </thead>
        <tbody>
            @php
                $tot_pemb_1 = ($data->total_pemb_1 == 0 ? "0" : ($data->nilai_pemb_1/$data->total_pemb_1));
                $tot_pemb_2 = ($data->total_pemb_2 == 0 ? "0" : ($data->nilai_pemb_2/$data->total_pemb_2));
                $tot_peng_1 = ($data->total_peng_1 == 0 ? "0" : ($data->nilai_pemb_2/$data->total_pemb_2));
                $tot_peng_2 = ($data->total_peng_2 == 0 ? "0" : ($data->nilai_pemb_2/$data->total_pemb_2));
            @endphp
            <tr>
                <td>1</td>
                <td>Pembimbing I</td>
                <td style="text-align: center;">{{$tot_pemb_1}}</td>
                <td>30% X {{$tot_pemb_1}} = {{30/100*$tot_pemb_1}}</td>
            </tr>
            <tr>
                <td>2</td>
                <td>Pembimbing II</td>
                <td style="text-align: center;">{{$tot_pemb_2}}</td>
                <td>30% X {{$tot_pemb_2}} = {{30/100*$tot_pemb_2}}</td>
            </tr>
            <tr>
                <td>3</td>
                <td>Penguji I</td>
                <td style="text-align: center;">{{$tot_peng_1}}</td>
                <td>20% X {{$tot_peng_1}} = {{30/100*$tot_peng_1}}</td>
            </tr>
            <tr>
                <td>4</td>
                <td>Penguji II</td>
                <td style="text-align: center;">{{$tot_peng_2}}</td>
                <td>20% X {{$tot_peng_2}} = {{30/100*$tot_peng_2}}</td>
            </tr>
        </tbody>
        <tfoot>
            @php
                $jumlah_keseluruhan = (30/100*$tot_pemb_1)+(30/100*$tot_pemb_2)+(20/100*$tot_peng_1)+(20/100*$tot_peng_2);
                if($jumlah_keseluruhan >= 80){
                    $nHuruf = 'A';
                }else if($jumlah_keseluruhan >= 75){
                    $nHuruf = 'AB';
                }else if($jumlah_keseluruhan >= 65){
                    $nHuruf = 'B';
                }else if($jumlah_keseluruhan >= 60){
                    $nHuruf = 'BC';
                }else if($jumlah_keseluruhan >= 55){
                    $nHuruf = 'C';
                }else if($jumlah_keseluruhan >= 40){
                    $nHuruf = 'D';
                }else if($jumlah_keseluruhan < 40){
                    $nHuruf = 'E';
                }

            @endphp
            <tr>
                <th colspan="3">JUMLAH</th>
                <th>{{$jumlah_keseluruhan}}</th>
            </tr>
            <tr>
                <th colspan="3">NILAI ANGKA</th>
                <th>{{$jumlah_keseluruhan}}</th>
            </tr>
            <tr>
                <th colspan="3">NILAI HURUF</th>
                <th>{{$nHuruf}}</th>
            </tr>
        </tfoot>
    </table>
    <br>
    <table width="100%">
        <tr>
            <td width="50%"></td>
            <td width="50%">Banyuwangi, {{$tanggal}}</td>
        </tr>
        <tr>
            <td width="50%"><span>Mengetahui</span></td>
            <td width="50%"></td>
        </tr>
        <tr>
            <td width="50%">
                <span>Ketua Prodi</span>
            </td>
            <td width="50%">
                <span>Dosen Pembimbing</span>
            </td>
        </tr>
        <tr>
            <td width="50%">
                <br><br><br><br><br>
            </td>
            <td width="50%">
                <br><br><br><br><br>
            </td>
        </tr>
        <tr>
            <td width="50%">
                ( <span><u>{{$kaprodi->name}}</u></span> )
                <br>
                @if (isset($kaprodi->nip))
                <span>NIPPPK. {{$kaprodi->nip}}</u></span>
                @endif
            </td>
            <td width="50%">
                @foreach ($nilai as $pmb)
                    @if ($pmb->jenis == 'pembimbing' && $pmb->urut == 1)
                        <span>( <u>{{$pmb->dosen->name}}</u> )</span>
                        <br>
                        <span>NIP. {{$pmb->dosen->nip}}</span>
                    @endif
                @endforeach
            </td>
        </tr>
    </table>

</div>
