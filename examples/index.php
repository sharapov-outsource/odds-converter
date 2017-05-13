<?php
/**
 * Odds converter examples
 *
 * (c) Alexander Sharapov <alexander@sharapov.biz>
 * http://sharapov.biz/
 *
 */

require_once "../vendor/autoload.php";

$converter = new \Sharapov\OddsConverter\OddsConverter();

// Set input in US format
$converter->setOdd('275');
// Get fractional format
print $converter->getFractional(); // 11/4
// Get decimal format
print $converter->getDecimal(); // 3.75

// Set input in Fractional format
$converter->setOdd('11/4');
// Get moneyline (US) format
print $converter->getMoneyline(); // 275
// Get decimal format
print $converter->getDecimal(); // 3.75

// Set input in Decimal format
$converter->setOdd('3.75');
// Get moneyline (US) format
print $converter->getMoneyline(); // 275
// Get fractional format
print $converter->getFractional(); // 11/4