<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendLinkToCustomer extends Mailable
{
    use Queueable, SerializesModels;

    public $id;
    public $prices;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($id,$prices)
    {
        $this->id = $id;
        $this->prices = $prices;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.linkEmail',['id'=>$this->id,'prices'=>$this->prices]);
    }
}
