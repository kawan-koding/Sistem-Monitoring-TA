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
            <td>FR-PRS-029</td>
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
    <center><h3>FORMULIR KESEDIAAN PEMBIMBING II</h3></center>
    <p>Saya yang bertanda tangan dibawah ini:</p>
    <table width="100%">
        <tr>
            <td width="25%">Nama (dengan gelar)</td>
            <td width="3%">:</td>
            <td>{{$pmb->dosen->name}}</td>
        </tr>
        <tr>
            <td width="25%">NIK./NIP.</td>
            <td width="3%">:</td>
            <td>{{$pmb->dosen->nip}}</td>
        </tr>
        <tr>
            <td colspan="3">
                <p>Dengan ini menyatakan bersedia menjadi Pembimbing II Tugas Akhir mahasiswa:</p>
            </td>
        </tr>


        
        <tr>
            <td width="25%">Nama</td>
            <td width="3%">:</td>
            <td>{{$ta->mahasiswa->nama_mhs}}</td>
        </tr>
        <tr>
            <td width="25%">NIM.</td>
            <td width="3%">:</td>
            <td>{{$ta->mahasiswa->nim}}</td>
        </tr>
        <tr>
            <td width="25%">Dengan Judul</td>
            <td width="3%">:</td>
            <td><span style="text-decoration: underline;">{{($ta->judul)}}</span></td>
        </tr>
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
                <span>Calon Pembimbing 1,</span>
            </td>
            <td width="50%">
                <span>Pemohon,</span>
            </td>
        </tr>
        <tr>
            <td width="50%">
                @if(isset($pmb->dosen->ttd))
                <img src="{{ public_path('images/'.$pmb->dosen->ttd) }}" width="100px" alt="Example Image">
                @endif
            </td>
            <td width="50%">
                <br><br><br><br><br>
            </td>
        </tr>
        <tr>
            <td width="50%">
                ( <span><u>{{$pmb->dosen->name}}</u></span> )
                <br>
                @if (isset($pmb->dosen->nip))
                <span>NIK./NIP./NIPPPK. {{$pmb->dosen->nip}}</u></span>
                @endif
            </td>
            <td width="50%">
                        <span>( <u>{{$ta->mahasiswa->nama_mhs}}</u> )</span>
                        <br>
                        <span>NIM. {{$ta->mahasiswa->nim}}</span>
            </td>
        </tr>
    </table>

</div>
