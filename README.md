Test Task for Commissions Calculations
==================

Usage
-------------------------------------------------------
You can run the script by executing:
```bash
$ php app.php [filename]
```

Example:
```bash
$ php app.php input.txt
```

Allowed file formats: **.txt, .json, .csv**.

**input.txt** already exists in the root directory.

Spent time on the task
-------------------------------------------------------
3 hours 30 minutes.


Unit Tests
-------------------------------------------------------
My solution also includes covering code with unit tests.
You can run it by:
```bash
$ vendor/bin/phpunit tests
```

Configuration
-------------------------------------------------------
You can easily change and replace Rates or BIN providers according to the test task requirements.
You can do it in the following way: open please **config.php** file and replace providers with the ones 
you would like to use.

```php
<?php
// config.php

return [
    'ratesProvider' => \App\Provider\Rates\ExchangeRatesProvider::class,
    'binProvider' => \App\Provider\BIN\LookupBinProvider::class,
];
```

Solution
-------------------------------------------------------
My code is extendable. It means that new BIN providers are supposed to be implemented in **app/Provider/BIN**.
Each new BIN provider is supposed to implement **BinProviderInterface**.
New Rates providers are supposed to be implemented in **app/Provider/Rates**.
Each new Rates provider is supposed to implement **RatesProviderInterface**.

Used Libraries
-------------------------------------------------------
My solution uses **composer** to install libraries and dependencies,  **Guzzle** library for HTTP requests/responces management.
It also uses **PHPUnit** and **CS Fixer** for dev environment to run unit tests and fix code style respectively.