<?php

namespace App\Http\Integrations\Anketa;

use Saloon\Http\Connector;
use Saloon\Traits\Plugins\AcceptsJson;

class AnketaConnector extends Connector
{
    use AcceptsJson;

    /**
     * The Base URL of the API
     */
    public function resolveBaseUrl(): string
    {
//        return "https://dev.api.1anketa.uz";
        return "http://127.0.0.1:8003";
    }

    /**
     * Default headers for every request
     */
    protected function defaultHeaders(): array
    {
        return [
            'Authorization' => 'Bearer UsEoP9Bsc6F3fBLAJpvAIUGGB8bhAuGigxQx5U9sOkIDoZOIH5DUycxgtZ4V7rOw',
        ];
    }

    /**
     * Default HTTP client options
     */
    protected function defaultConfig(): array
    {
        return [
            'timeout' => 30,
        ];
    }
}
