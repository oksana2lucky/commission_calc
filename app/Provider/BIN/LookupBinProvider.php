<?php

namespace App\Provider\BIN;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

/**
 * Class LookupBinProvider
 *
 * Lookup BIN Provider implementation
 */
class LookupBinProvider implements BinProviderInterface
{
    private const BINLIST_API_URL = 'https://lookup.binlist.net/';

    /**
     * Get BIN results.
     *
     * @param string $bin BIN number.
     *
     * @return mixed BIN results data or null if not found.
     */
    public function getBinResults(string $bin)
    {
        $client = new Client();
        $url = self::BINLIST_API_URL . $bin;

        // Send the HTTP request
        $response = $client->get($url, ['http_errors' => false]);

        // Check the response status code
        return $response->getStatusCode() === 200 ?
            json_decode($response->getBody()->getContents()) :
            null;
    }
}
