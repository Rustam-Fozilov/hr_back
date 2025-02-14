<?php

namespace App\Http\Integrations\Invoice;

use Saloon\Http\Connector;
use Saloon\Traits\Plugins\AcceptsJson;

class InvoiceConnector extends Connector
{
    use AcceptsJson;

    /**
     * The Base URL of the API
     */
    public function resolveBaseUrl(): string
    {
        return "https://back.e-invoice.uz";
    }

    /**
     * Default headers for every request
     */
    protected function defaultHeaders(): array
    {
        return [
            'Authorization' => 'Bearer 156270|uZW1dtiHy7db2kGvKAzzMV6M746aP6JI4MRrt3Wt731765fc',
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
