<?php

namespace App\Provider\Rates;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

/**
 * Class ExchangeRatesProvider
 *
 * Exchange Rates Provider implementation
 */
class ExchangeRatesProvider implements RatesProviderInterface
{
    private const API_KEY = 'lBTxxYHb46EzbhE6crdQvFr50P2TLp8H';
    private const EXCHANGE_API_URL = 'https://api.apilayer.com/exchangerates_data/latest';

    /**
     * @return array
     */
    public function getExchangeRates(): array
    {
        $client = new Client();

        $headers = [
            'Content-Type' => 'text/plain',
            'apikey' => self::API_KEY,
        ];

        try {
            $response = $client->request('GET', self::EXCHANGE_API_URL, [
                'headers' => $headers,
            ]);

            $responseBody = $response->getBody()->getContents();

            $data = json_decode($responseBody, true);
            return $data['rates'] ?? [];
        } catch (GuzzleException $e) {
            // Handle the exception or log the error if needed
            return [];
        }
    }
}
