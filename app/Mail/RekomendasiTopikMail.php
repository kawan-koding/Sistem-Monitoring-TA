<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RekomendasiTopikMail extends Mailable
{
    use Queueable, SerializesModels;

    public $rekomendasiTopik, $mahasiswa;

    public function __construct($rekomendasiTopik, $mahasiswa)
    {
        $this->rekomendasiTopik = $rekomendasiTopik;
        $this->mahasiswa = $mahasiswa;
        // dd($rekomendasiTopik, $mahasiswa);
    }

    public function envelope()
    {
        return new Envelope(
            subject: 'Rekomendasi Topik Tugas Akhir',
        );
    }

    public function content()
    {
        return new Content(
            view: 'emails.setujui-rekomendasi-topik',
        );
    }
    // public function build()
    // {
    //     return $this->subject('Rekomendasi Topik Tugas Akhir')
    //                 ->view('emails.setujui-rekomendasi-topik');
    // }

}
