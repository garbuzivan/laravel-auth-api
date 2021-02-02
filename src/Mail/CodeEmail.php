<?php

namespace GarbuzIvan\LaravelAuthApi\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CodeEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var array
     */
    public array $data;

    /**
     * CodeEmail constructor.
     * @param $data
     */
    public function __construct($data)
    {
        $this->data = $data;
        $this->data['title'] = $this->data['title'] ?? null;
        $this->data['subject'] = $this->data['subject'] ?? $this->data['title'];
        $this->data['view'] = $this->data['view'] ?? 'gi_laravel_auth_api::mail';
    }

    /**
     * @return CodeEmail
     */
    public function build()
    {
        return $this->subject($this->data['subject'])->view($this->data['view']);
    }
}
