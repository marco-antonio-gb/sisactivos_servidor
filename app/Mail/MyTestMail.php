<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MyTestMail extends Mailable implements ShouldQueue {
	use Queueable, SerializesModels;
	 
	public $data;
	public function __construct($data) {
		$this->data = $data;
	}

	/**
	 * Build the message.
	 *
	 * @return $this
	 */
	public function build() {
        // return $this->markdown('mail.emailTest')->subject('Por favor confirma tu correo');
        return $this->markdown('mail.emailTest')
        ->with('data', $this->data);
        
	}
}
