<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class KontrakMailler extends Mailable
{

    use Queueable, SerializesModels;

    public $data; // variabel untuk dikirim ke view

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function build()
    {
        return $this->subject('Kontak Anda Tidak Diperpanjang')
                    ->view('emails.tidak_perpanjang'); // View akan kita buat nanti
    }
}
