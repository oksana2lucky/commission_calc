<?php

namespace App\Calculator;

use App\Provider\Rates\RatesProviderInterface;
use App\Provider\BIN\BinProviderInterface;

/**
 * Class CommissionCalculator
 *
 * Calculate commissions based on exchange rates and BIN data.
 */
class CommissionCalculator
{
    /**
     * @var RatesProviderInterface Rates provider.
     */
    private RatesProviderInterface $ratesProvider;

    /**
     * @var BinProviderInterface BIN provider.
     */
    private BinProviderInterface $binProvider;

    /**
     * CommissionCalculator constructor.
     *
     * @param RatesProviderInterface $ratesProvider Rates provider instance.
     * @param BinProviderInterface   $binProvider   BIN provider instance.
     */
    public function __construct(RatesProviderInterface $ratesProvider, BinProviderInterface $binProvider)
    {
        $this->ratesProvider = $ratesProvider;
        $this->binProvider = $binProvider;
    }

    /**
     * Calculate commissions based on input data from a file.
     *
     * @param string $inputData input file content.
     *
     * @throws \Exception If any error occurs during the calculation.
     */
    public function calculateCommissions(string $inputData): void
    {
        $rates = $this->ratesProvider->getExchangeRates();
        $rows = explode("\n", $inputData);
        foreach ($rows as $row) {
            if (empty($row)) {
                continue;
            }
            $data = json_decode($row, true);
            $bin = $data['bin'];
            $amount = $data['amount'];
            $currency = $data['currency'];

            $binResults = $this->binProvider->getBinResults($bin);
            if (!$binResults) {
                throw new \Exception('Error fetching BIN data!');
            }

            $countryAlpha2 = $binResults->country->alpha2;
            $isEu = $this->isEu($countryAlpha2);

            if (isset($rates[$currency])) {
                $rate = $rates[$currency];
            } else {
                throw new \Exception("Currency rate for {$currency} not found in rates array!");
            }

            $amntFixed = ($currency == 'EUR' || $rate == 0) ? $amount : $amount / $rate;
            $commission = $amntFixed * ($isEu ? 0.01 : 0.02);

            // Format the commission with two decimal places and replace ',' with '.'
            $formattedCommission = number_format($commission, 2, '.', '');

            echo $formattedCommission . "\n";
        }
    }

    /**
     * Check if a country is in the EU based on its alpha2 code.
     *
     * @param string $countryCode Country's alpha2 code.
     *
     * @return bool True if the country is in the EU, false otherwise.
     */
    private function isEu(string $countryCode): bool
    {
        $euCountries = ['AT', 'BE', 'BG', 'CY', 'CZ', 'DE', 'DK', 'EE', 'ES', 'FI', 'FR', 'GR', 'HR', 'HU', 'IE', 'IT',
            'LT', 'LU', 'LV', 'MT', 'NL', 'PO', 'PT', 'RO', 'SE', 'SI', 'SK'];
        return in_array($countryCode, $euCountries);
    }
}
