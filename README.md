# PhpUnitExtended
[![License](https://img.shields.io/github/license/yoanm/PhpUnitExtended.svg)](https://github.com/yoanm/PhpUnitExtended) [![Code size](https://img.shields.io/github/languages/code-size/yoanm/PhpUnitExtended.svg)](https://github.com/yoanm/PhpUnitExtended) [![PHP Versions](https://img.shields.io/badge/php-7.1%20%2F%207.2-8892BF.svg)](https://php.net/)

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/yoanm/PhpUnitExtended/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/yoanm/PhpUnitExtended/?branch=master) [![Build Status](https://scrutinizer-ci.com/g/yoanm/PhpUnitExtended/badges/build.png?b=master)](https://scrutinizer-ci.com/g/yoanm/PhpUnitExtended/build-status/master) [![Code Coverage](https://scrutinizer-ci.com/g/yoanm/PhpUnitExtended/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/yoanm/PhpUnitExtended/?branch=master)

[![Travis Build Status](https://img.shields.io/travis/yoanm/PhpUnitExtended/master.svg?label=travis)](https://travis-ci.org/yoanm/PhpUnitExtended) [![Travis PHP versions](https://img.shields.io/travis/php-v/yoanm/PhpUnitExtended.svg)](https://travis-ci.org/yoanm/PhpUnitExtended)

[![Latest Stable Version](https://img.shields.io/packagist/v/yoanm/php-unit-extended.svg)](https://packagist.org/packages/yoanm/php-unit-extended) [![Packagist PHP version](https://img.shields.io/packagist/php-v/yoanm/php-unit-extended.svg)](https://packagist.org/packages/yoanm/php-unit-extended)

Php library to extend PhpUnit

 * [Install](#install)
 * [In the box](#in-the-box)
   * [Listeners](#in-the-box-listeners)
 * [Contributing](#contributing)

## Install
```bash
composer require --dev yoanm/php-unit-extended
```

## In the box

<a name="in-the-box-listeners"></a>
### Listeners

 * DelegatingListener

 A Simple listener delegator. Used for **YoanmTestsStrategyListener**.
 * [RiskyToFailedListener](./doc/listener/RiskyToFailedListener.md)
 * [StrictCoverageListener](./doc/listener/StrictCoverageListener.md)
 * [YoanmTestsStrategyListener](./doc/listener/YoanmTestsStrategyListener.md)

## Contributing
See [contributing note](./CONTRIBUTING.md)
