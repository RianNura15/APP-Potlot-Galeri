<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class emailVerifikasi extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public $email;
    public $nama;

    public function __construct($email, $nama)
    {
        $this->email = $email;
        $this->nama = $nama;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // dd("disini");
        return $this->from('potlot_galeri@gmail.com', 'Potlot Galeri')
            ->view('emails.emailVerifikasi')
            ->with([
                'email' => $this->email,
                'nama' => $this->nama
            ]);
    }
}
