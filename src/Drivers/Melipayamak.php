<?php

namespace Amirhajipoor\Darkob\Drivers;

use Amirhajipoor\Darkob\Exceptions\DarkobException;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Carbon;

class Melipayamak extends Driver
{
    public $base_uri = 'https://console.melipayamak.com/api';

    /**
     * Send by pattern
     * @param string $phone_number
     * @param int $pattern
     * @param array $params
     */
    public function sendByPattern(string $phone_number, string $pattern, array $params): int
    {
        $data = [
            'bodyId' => (int) $pattern,
            'to' => $phone_number,
            'args' => $params,
        ];

        try {
            $response = $this->client->post('/api/send/shared/'.config('darkob.drivers.melipayamak.key'), [
                'json' => $data,
            ]);

            $data = json_decode($response->getBody());

            if ($response->getStatusCode() === 200) {
                if (isset($data->recId)) {
                    // successful
                    return $data->recId;
                } else {
                    // melipayamak error
                    throw new DarkobException($data->status);
                }
            }

        } catch (GuzzleException $e) {
            // network error about guzzle
            throw $e;
        }
    }

    /**
     * Send to one person
     * @param string $from
     * @param string $phone_number
     * @param string $text
     */
    public function sendNormal(string $from, string $phone_number, string $text)
    {
        $data = [
            'from' => $from,
            'to' => $phone_number,
            'text' => $text,
        ];

        $response = $this->client->post('/api/send/simple/'.config('darkob.drivers.melipayamak.key'), [
            'json' => $data,
        ]);
            
        
        try {

            $data = json_decode($response->getBody());

            if ($response->getStatusCode() === 200) {
                if (isset($data->recId)) {
                    // successful
                    return $data->recId;
                } else {
                    // melipayamak error
                    throw new DarkobException($data->status);
                }
            }

        } catch (GuzzleException $e) {
            // network error about guzzle
            throw $e;
        }

        return true;
    }

    /**
     * Send to one person on specific time
     * @param string $from
     * @param string $phone_number
     * @param string $text
     */
    public function sendScheduled(string $from, string $phone_number, string $text, Carbon $time)
    {
        $data = [
            'from' => $from,
            'to' => $phone_number,
            'message' => $text,
            'date' => $time->format('m/d/Y H:i'),
        ];

        $response = $this->client->post('/api/send/schedule/'.config('darkob.drivers.melipayamak.key'), [
            'json' => $data,
        ]);
            
        try {

            $data = json_decode($response->getBody());

            if ($response->getStatusCode() === 200) {
                if (isset($data->id)) {
                    // successful
                    return $data->id;
                } else {
                    // melipayamak error
                    throw new DarkobException($data->status);
                }
            }

        } catch (GuzzleException $e) {
            // network error about guzzle
            throw $e;
        }

        return true;
    }
}
