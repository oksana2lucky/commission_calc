<?php

// tests/ExchangeRatesProviderTest.php

use PHPUnit\Framework\TestCase;
use App\Provider\Rates\ExchangeRatesProvider;

class ExchangeRatesProviderTest extends TestCase
{
    public function testGetExchangeRates()
    {
        // Create the ExchangeRatesProvider instance
        $provider = new ExchangeRatesProvider();

        // Call the getExchangeRates() method
        $rates = $provider->getExchangeRates();

        // Assert that the return value is an array
        $this->assertIsArray($rates);

        // Assert that the array is not empty
        $this->assertNotEmpty($rates);
    }
}
