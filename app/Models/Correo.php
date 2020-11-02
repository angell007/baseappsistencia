<?php
 
namespace App\Models;
 
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
 
class Correo extends Mailable
{
    use Queueable, SerializesModels;
     
    /**
     * The correo object instance.
     *
     * @var Correo
     */
    public $correo;
 
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($correo)
    {
        $this->correo = $correo;
    }
 
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from($this->correo->destino)
                    ->view('mails.asistencia')
                    ->text('mails.asistencia_plano');
                    
    }
}