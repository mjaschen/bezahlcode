# Change Log

All notable changes to `mjaschen/phpgeo` will be documented in this file.
Updates should follow the [Keep a CHANGELOG](http://keepachangelog.com/) principles.

## [3.0.0] - 2021-08-27

### changes which breaking backwards compatibility

Thanks to @m-ober for working on this!

- increased minimum required PHP version to 7.3
- add support for PHP 8.0
- update PHPUnit to 9.x
- update tests
- upgrade endroid/qr-code to v4 and adjust to new API
- Bezahlcode parameters (recipient, IBAN, ...) are now all of type *string* with one exception: the amount has to be provided as float (will be upgraded to a money class in the next major release)
- `saveBezahlCode()` and `getBezahlCode()` now both accept a type argument ('png', 'svg', etc.; default value is 'png')
