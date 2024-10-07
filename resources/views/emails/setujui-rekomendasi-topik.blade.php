<div>
    <h2>Selamat atas pilihan topik Tugas Akhir Anda!</h2>
    <p>Kepada, <b>{{ $mahasiswa->nama_mhs }}</b></p>
    <p style="text-align: justify ">Kami dengan sengan hati mengonfirmasi bahwa anda telah disetujui mengambil topik Tugas Akhir yang ditawarkan oleh :</p>
    <ul style="margin-left: -20px;">
        <li>Calon Dosen Pembimbing:<strong> {{ $rekomendasiTopik->dosen->name }} </strong></li>
        <li>Judul Topik:<strong> {{ $rekomendasiTopik->judul }}</strong></li>
    </ul>
    <p>Kami berharap Anda menjalani penelitian ini dengan penuh semangat dan dedikasi.</p>
    <p style="text-align: justify ">Selanjutnya silahkan hubungi calon dosen pembimbing anda untuk berdiskusi lebih lanjut terkait topik Tugas Akhir anda.</p>
    <p>Terima kasih</p>
</div>    

