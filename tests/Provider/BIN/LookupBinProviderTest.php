<?php
// tests/LookupBinProviderTest.php

use PHPUnit\Framework\TestCase;
use App\Provider\BIN\LookupBinProvider;

class LookupBinProviderTest extends TestCase
{
    public function testGetBinResults()
    {
        // Create the LookupBinProvider instance
        $provider = new LookupBinProvider();

        // Test with a valid BIN number
        $bin = '45717360';
        $result = $provider->getBinResults($bin);

        // Assert that the result is not null
        $this->assertNotNull($result);

        // Assert that the result is an object
        $this->assertIsObject($result);

        // Assert that the object has the expected property
        $this->assertTrue(property_exists($result, 'country'));
        $this->assertFalse(property_exists($result, 'error'));

        // Test with an invalid BIN number
        $invalidBin = 'invalid';
        $result = $provider->getBinResults($invalidBin);

        // Assert that the result is null
        $this->assertNull($result);
    }
}
