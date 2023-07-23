<?php

return [
    'ratesProvider' => \App\Provider\Rates\ExchangeRatesProvider::class,
    'binProvider' => \App\Provider\BIN\LookupBinProvider::class,
];
