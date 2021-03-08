<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Invoice;

class ProcessInvoice implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    private $invoice, $address, $seats;
    public function __construct(Invoice $invoice, $address, $seats)
    {
        $this->invoice = $invoice;
        $this->address = $address;
        $this->seats = $seats;
        
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        \Mail::to($this->address)->send(new \App\Mail\Invoice($this->invoice,$this->seats));
    }
}
