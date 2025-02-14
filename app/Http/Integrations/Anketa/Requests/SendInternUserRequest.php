<?php

namespace App\Http\Integrations\Anketa\Requests;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

class SendInternUserRequest extends Request implements HasBody
{
    use HasJsonBody;
    public function __construct(
        protected array $data
    )
    {
    }

    /**
     * The HTTP method of the request
     */
    protected Method $method = Method::POST;

    /**
     * The endpoint for the request
     */
    public function resolveEndpoint(): string
    {
        return '/api/all_projects/store/intern/user';
    }

    public function defaultBody(): array
    {
        return $this->data;
    }
}
