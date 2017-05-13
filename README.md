Odds Converter
======================

Convert odds between american, decimal, and fractional formats

Installation
------------

You can either get the files from GIT or you can install the library via [Composer](getcomposer.org). To use Composer, simply add the following to your `composer.json` file.

```json
{
    "require": {
        "sharapov/odds-converter": "dev-master"
    }
}
```

How to use it?
--------------

```php
require_once "../vendor/autoload.php";

$converter = new \Sharapov\OddsConverter\OddsConverter($odd);
```

Set up your input odd in the decimal, fractional or moneyline (US) format

#### Set moneyline (US) input
```php
$converter->setOdd('275');
```

##### Get fractional
```php
print $converter->getFractional(); // 11/4
```

##### Get decimal
```php
print $converter->getDecimal(); // 3.75
```


#### Set fractional input
```php
$converter->setOdd('11/4');
```

##### Get moneyline (US)
```php
print $converter->getMoneyline(); // 275
```

##### Get decimal
```php
print $converter->getDecimal(); // 3.75
```

#### Set decimal input
```php
$converter->setOdd('3.75');
```

##### Get moneyline (US)
```php
print $converter->getMoneyline(); // 275
```

##### Get fractional
```php
print $converter->getFractional(); // 11/4
```

That's so easy