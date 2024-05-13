<?php

namespace Amirhajipoor\Darkob\Drivers;

use GuzzleHttp\Client;

class Driver
{
    public $base_uri;

    public $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => $this->base_uri,
        ]);
    }
}
