<?php

namespace App\Jobs;

use App\Http\Integrations\Anketa\AnketaConnector;
use App\Http\Integrations\Anketa\Requests\SendInternUserRequest;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Saloon\Exceptions\SaloonException;

class SendInternUserJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(protected array $data)
    {
        //
    }

    public function handle(): void
    {
        $send = (new AnketaConnector())->send(new SendInternUserRequest($this->data));
        if ($send->failed()) throw new SaloonException($send->body());
    }
}
