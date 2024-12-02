<?php

namespace App\Mail;

use App\Services\SettingService;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class GlobalMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(public $subject, public string $content){}

    public function build()
    {
        SettingService::mail();

        return $this->subject($this->subject)
            ->view('emails.template',[
                'content' => $this->content,
            ]);
    }
}
