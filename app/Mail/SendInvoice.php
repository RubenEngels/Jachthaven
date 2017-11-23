<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\User;
use App\Invoice;

class SendInvoice extends Mailable
{
    use Queueable, SerializesModels;


    public $invoice_link;
    public $user;
    public $invoice;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($invoice_link, $user_id, $invoice_id)
    {
        $this->user = User::findOrFail($user_id);
        $this->invoice_link = $invoice_link;
        $this->invoice = Invoice::findOrFail($invoice_id);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        return $this->markdown('mail.send_invoice')
        ->attach($this->invoice_link, [
          'as' => 'factuur.pdf',
          'mime' => 'application/pdf',
        ])
        ->subject('Factuur ' . config('app.name'));
    }
}
