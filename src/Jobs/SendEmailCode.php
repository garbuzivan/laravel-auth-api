<?php

declare(strict_types=1);

namespace GarbuzIvan\LaravelAuthApi\Jobs;

use GarbuzIvan\LaravelAuthApi\Mail\CodeEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendEmailCode implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     *
     * @param array $details
     * @return void
     */
    public function handle(array $details)
    {
        Mail::to($details['to'])->send(new CodeEmail($details));
        return "Success";
    }
}
