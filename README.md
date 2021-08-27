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

## Requirements

*BezahlCode* requires at least PHP 7.3. PHP 8.0 is fully supported.

If you're using an older PHP version, you can install:

- *BezahlCode* 2.x which is compatible to PHP versions >= 7.1 or
- *BezahlCode* 1.x which is compatible to PHP versions >= 5.3.

## Installation

*BezahlCode* is installed via [Composer](http://getcomposer.org/):

Just add it to your `composer.json` by running:

```
composer require mjaschen/bezahlcode
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
echo $bezahlCode->getBezahlCode('png');
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

$file = sys_get_temp_dir() . DIRECTORY_SEPARATOR . "bezahlcode_test.svg";

$bezahlCode->saveBezahlCode($file, 'svg');
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
* [QR Code](https://github.com/endroid/qr-code)
* [BezahlCode](http://www.bezahlcode.de/)
* BezahlCode [Specification](http://www.bezahlcode.de/wp-content/uploads/BezahlCode_TechDok.pdf) (PDF)
