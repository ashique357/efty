<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Invoice extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    private $invoice,$seats;
    public function __construct(\App\Invoice $invoice,$seats)
    {
        $this->invoice = $invoice;
        $this->seats = $seats;
    
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.seatBooked')->with(['invoice'=>$this->invoice,'seats'=>$this->seats]);
    }
}
