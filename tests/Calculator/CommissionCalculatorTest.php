<?php

use PHPUnit\Framework\TestCase;
use App\Calculator\CommissionCalculator;
use App\Provider\Rates\RatesProviderInterface;
use App\Provider\BIN\BinProviderInterface;

class CommissionCalculatorTest extends TestCase
{
    public function testCalculateCommissions()
    {
        // Create mock objects for RatesProviderInterface and BinProviderInterface
        $ratesProviderMock = $this->createMock(RatesProviderInterface::class);
        $binProviderMock = $this->createMock(BinProviderInterface::class);

        // Set up the rates and BIN data for testing
        $rates = [
            'USD' => 1.2,
            'GBP' => 0.8,
            'EUR' => 1.0,
            'JPY' => 0.01,
        ];
        $binData = json_decode('{"country":{"alpha2":"DE"}}');

        // Mock the methods in RatesProviderInterface and BinProviderInterface
        $ratesProviderMock->expects($this->any())
            ->method('getExchangeRates')
            ->willReturn($rates); // Return the rates directly as an array

        $binProviderMock->expects($this->any())
            ->method('getBinResults')
            ->willReturn($binData);

        // Create the CommissionCalculator instance with the mock objects
        $calculator = new CommissionCalculator($ratesProviderMock, $binProviderMock);

        // Set up the test input data
        $inputData = '{"bin":"45717360","amount":"100.00","currency":"EUR"}
            {"bin":"516793","amount":"50.00","currency":"USD"}
            {"bin":"45417360","amount":"10000.00","currency":"JPY"}
            {"bin":"41417360","amount":"130.00","currency":"USD"}
            {"bin":"4745030","amount":"2000.00","currency":"GBP"}';

        // Capture the output
        ob_start();
        $calculator->calculateCommissions($inputData);
        $output = ob_get_clean();

        // Define the expected output
        $expectedOutput = "1.00\n0.42\n10000.00\n1.08\n25.00\n";

        // Assert that the output matches the expected output
        $this->assertEquals($expectedOutput, $output);
    }

    public function testIsEu()
    {
        // Create a ReflectionClass object for CommissionCalculator
        $reflector = new \ReflectionClass(CommissionCalculator::class);

        // Get the isEu method and make it accessible
        $method = $reflector->getMethod('isEu');
        $method->setAccessible(true);

        // Create an instance of CommissionCalculator for testing
        $calculator = new CommissionCalculator($this->createMock(RatesProviderInterface::class),
            $this->createMock(BinProviderInterface::class));

        // Test EU country code
        $this->assertTrue($method->invoke($calculator, 'DE'));

        // Test non-EU country code
        $this->assertFalse($method->invoke($calculator, 'US'));
    }
}