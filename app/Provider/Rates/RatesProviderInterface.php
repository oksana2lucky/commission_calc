<?php

namespace App\Provider\Rates;

/**
 * Interface RatesProviderInterface
 *
 * Interface for exchange rates provider.
 */
interface RatesProviderInterface
{
    /**
     * Get exchange rates.
     *
     * @return array Associative array of exchange rates.
     */
    public function getExchangeRates(): array;
}
