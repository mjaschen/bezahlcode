# BezahlCode PHP Library

[![Latest Stable Version](https://poser.pugx.org/mjaschen/bezahlcode/v/stable.png)](https://packagist.org/packages/mjaschen/bezahlcode)

## Introduction

*BezahlCode* is a PHP library for creating BezahlCode QR-Code images.

## Installation

*BezahlCode* is installed via [Composer](http://getcomposer.org/):

``` json
{
    "require": {
        "mjaschen/bezahlcode": "0.1.1"
    }
}
```

## Usage

Currently only two types are implemented: *Classic Transfer* and *SEPA Transfer.*

### SEPA Transfer

Output a BezahlCode image directly to the browser:

``` php
<?php

use MarcusJaschen\BezahlCode\Type\SepaTransfer;

$bezahlcode = new SepaTransfer();

$bezahlCode->setTransferData(
    "Marcus Jaschen",
    "DE12345678901234567890",
    "SPARDEFFXXX",
    99.99,
    "Test SEPA Transfer"
);

header('Content-type: image/png');
echo $bezahlCode->getBezahlCode();
```

Save a BezahlCode image to a file:

``` php
<?php

use MarcusJaschen\BezahlCode\Type\SepaTransfer;

$bezahlcode = new SepaTransfer();

$bezahlCode->setTransferData(
    "Marcus Jaschen",
    "DE12345678901234567890",
    "SPARDEFFXXX",
    99.99,
    "Test SEPA Transfer"
);

$file = sys_get_temp_dir() . DIRECTORY_SEPARATOR . "bezahlcode_test.png";

$bezahlCode->saveBezahlCode($file);
```

Get BezahlCode URI:

``` php
<?php

use MarcusJaschen\BezahlCode\Type\SepaTransfer;

$bezahlcode = new SepaTransfer();

$bezahlCode->setTransferData(
    "Marcus Jaschen",
    "DE12345678901234567890",
    "SPARDEFFXXX",
    99.99,
    "Test SEPA Transfer"
);

echo $bezahlcode->getBezahlCodeURI();
```

### Classic Transfer

Output a BezahlCode image directly to the browser:

``` php
<?php

use MarcusJaschen\BezahlCode\Type\Transfer;

$bezahlcode = new Transfer();

$bezahlCode->setTransferData(
    "Marcus Jaschen",
    "1234567890",
    "10050000",
    99.99,
    "Test Classic Transfer"
);

header('Content-type: image/png');
echo $bezahlCode->getBezahlCode();
```

Saving a BezahlCode to a file and getting the BezahlCode URI works as described in the *SEPA Transfer* section.

## Bugs / To Do

* TODO: implement missing authorities (*singledirectdebit, periodicsinglepayment, contact, contactv2*)
* TODO: write more Tests

## Credits

* [Marcus Jaschen](https://github.com/mjaschen)
* [PHP QR Code Library](http://phpqrcode.sourceforge.net)
* [Ariel Ferrandini](https://github.com/aferrandini) - PHP QR Code Composer Package
* [BezahlCode](http://www.bezahlcode.de/)