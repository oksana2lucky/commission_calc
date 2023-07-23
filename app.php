<?php

require_once 'vendor/autoload.php';
use App\Calculator\CommissionCalculator;

try {
    // Get providers classes from configuration
    $config = require_once __DIR__ . '/config.php';
    $ratesProviderClass = $config['ratesProvider'];
    $binProviderClass = $config['binProvider'];

    if (!isset($config['ratesProvider']) || !isset($config['binProvider'])) {
        throw new Exception('Rates and BIN providers are not configured properly.');
    }

    // Create providers
    $ratesProvider = new $ratesProviderClass();
    $binProvider = new $binProviderClass();
    $calculator = new CommissionCalculator($ratesProvider, $binProvider);

    // Get input data and calculate
    if (isset($argv[1])) {
        $potentialInputFile = $argv[1];
        if (is_file($potentialInputFile)) {
            $fileExtension = pathinfo($potentialInputFile, PATHINFO_EXTENSION);

            // Define an array of allowed file extensions
            $allowedExtensions = ['txt', 'json', 'csv'];

            // Check if the file extension is allowed
            if (in_array($fileExtension, $allowedExtensions)) {
                $inputFile = $potentialInputFile;
                $inputData = file_get_contents($inputFile);
                $calculator->calculateCommissions($inputData);
            } else {
                throw new \InvalidArgumentException("Invalid input file format: {$fileExtension}. Allowed formats are: " . implode(', ', $allowedExtensions));
            }
        } else {
            throw new \InvalidArgumentException("Invalid input file specified: {$potentialInputFile}");
        }
    }

} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage() . "\n";
}

