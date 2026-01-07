<?php

require __DIR__ . '/vendor/autoload.php';

use App\Calculator;

$calc = new Calculator();

echo "5 + 10 = " . $calc->add(5, 10) . PHP_EOL;
echo "20 - 5 = " . $calc->subtract(20, 5) . PHP_EOL;
echo "3 × 6 = " . $calc->multiply(3, 6) . PHP_EOL;
echo "10 ÷ 2 = " . $calc->divide(10, 2) . PHP_EOL;
