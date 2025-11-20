<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailVerificationCode extends Mailable
{
    use Queueable, SerializesModels;

    public $code;
    public $name;

    public function __construct(string $code, ?string $name = null)
    {
        $this->code = $code;
        $this->name = $name;
    }

    public function build()
    {
        return $this->subject('Kode Verifikasi Email Anda')
                    ->view('emails.verification_code')
                    ->with([
                        'code' => $this->code,
                        'name' => $this->name,
                    ]);
    }
}
