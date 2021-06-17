<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class EnviarEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The demo object instance.
     *
     * @var Demo
     */
    public $demo;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($demo)
    {
        $this->demo = $demo;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(env('MAIL_USERNAME'))
                    ->subject('Sercoamb - Aviso de Medicion')
                    ->view('mails.demo')
                    ->text('mails.demo_plain')
                    ->with(
                            [
                                'sender' => $this->demo->sender,
								'registro' => $this->demo->registro,
                                'rut' => $this->demo->rut,
                                'empresa' => $this->demo->empresa,
                                'receiver' => $this->demo->receiver,
                                'codigometodo' => $this->demo->codigometodo,
                                'tipofuente' => $this->demo->tipofuente,
                                'fechamedicion' => $this->demo->fechamedicion
                            ])
                    ->attach(public_path('/img').'/logo.png', [
                                'as' => 'logo.png',
                                'mime' => 'image/png',
                    ]);
    }
}
