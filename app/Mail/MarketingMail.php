<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MarketingMail extends Mailable
{
    use Queueable, SerializesModels;

    public $details;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($details)
    {
        $this->details = $details;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $body_en = htmlspecialchars_decode($this->details['body_en'],ENT_HTML5);
        $body_ar = htmlspecialchars_decode($this->details['body_ar'],ENT_HTML5);
        return $this->subject($this->details['subject'])
            ->view('admin.components.email_template.template',compact('body_en','body_ar'));
    }
}
