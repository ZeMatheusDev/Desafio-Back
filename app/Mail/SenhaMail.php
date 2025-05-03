<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SenhaMail extends Mailable
{
    use Queueable, SerializesModels;

    public $senha;

    public function __construct($senha)
    {
        $this->senha = $senha;
    }

    public function build()
    {
        $mensagem = "Sua senha de acesso é: {$this->senha}";

        $titulo = 'Recuperação de senha';

        return $this->html($mensagem)
            ->subject($titulo);
    }
}
