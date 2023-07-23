<?php

namespace App\Provider\BIN;

/**
 * Interface BinProviderInterface
 *
 * Interface for BIN data provider.
 */
interface BinProviderInterface
{
    /**
     * Get BIN results.
     *
     * @param string $bin BIN number.
     *
     * @return mixed BIN results data or null if not found.
     */
    public function getBinResults(string $bin);
}
