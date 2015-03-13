# BezahlCode PHP Library

[![Build Status](https://travis-ci.org/mjaschen/bezahlcode.png?branch=master)](https://travis-ci.org/mjaschen/bezahlcode) [![Latest Stable Version](https://poser.pugx.org/mjaschen/bezahlcode/v/stable.png)](https://packagist.org/packages/mjaschen/bezahlcode)

## Introduction

*BezahlCode* is a PHP library for creating BezahlCode QR-Code images and URIs.

## Table of Contents

- [Installation](#installation)
- [Usage](#usage)
	- [SEPA Transfer](#sepa-transfer)
	- [Classic Transfer](#classic-transfer)
	- [Other Types](#other-types)
- [Bugs / To Do](#bugs-to-do)
- [Credits](#credits)

## Installation

*BezahlCode* is installed via [Composer](http://getcomposer.org/):

Just add it to your `composer.json` by running (preferred method):

```
composer require mjaschen/bezahlcode
```

Or add it manually to your `composer.json` (legacy method):

``` json
{
    "require": {
        "mjaschen/bezahlcode": "~1.0"
    }
}
```

## Usage

### SEPA Transfer

Output a BezahlCode image directly to the browser:

``` php
<?php

use MarcusJaschen\BezahlCode\Type\SepaTransfer;

$bezahlCode = new SepaTransfer();

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

$bezahlCode = new SepaTransfer();

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

$bezahlCode = new SepaTransfer();

$bezahlCode->setTransferData(
    "Marcus Jaschen",
    "DE12345678901234567890",
    "SPARDEFFXXX",
    99.99,
    "Test SEPA Transfer"
);

echo $bezahlCode->getBezahlCodeURI();
```

### Classic Transfer

Output a BezahlCode image directly to the browser:

``` php
<?php

use MarcusJaschen\BezahlCode\Type\Transfer;

$bezahlCode = new Transfer();

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

### Other Types

* Periodic Transfer
* Periodic SEPA Transfer
* Direct Debit
* SEPA Direct Debit

## Bugs / To Do

* TODO: implement missing authorities (*contact, contactv2*)
* TODO: write more Tests

## Credits

* [Marcus Jaschen](https://github.com/mjaschen)
* [PHP QR Code Library](http://phpqrcode.sourceforge.net)
* [Ariel Ferrandini](https://github.com/aferrandini) - PHP QR Code Composer Package
* [BezahlCode](http://www.bezahlcode.de/)
* BezahlCode [Specification](http://www.bezahlcode.de/wp-content/uploads/BezahlCode_TechDok.pdf) (PDF)
