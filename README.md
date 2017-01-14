# PhpUnitExtended
[![Scrutinizer Build Status](https://img.shields.io/scrutinizer/build/g/yoanm/PhpUnitExtended.svg?label=Scrutinizer)](https://scrutinizer-ci.com/g/yoanm/PhpUnitExtended/?branch=master) [![Scrutinizer Code Quality](https://img.shields.io/scrutinizer/g/yoanm/PhpUnitExtended.svg?label=Code%20quality)](https://scrutinizer-ci.com/g/yoanm/PhpUnitExtended/?branch=master) [![Code Coverage](https://img.shields.io/scrutinizer/coverage/g/yoanm/PhpUnitExtended.svg?label=Coverage)](https://scrutinizer-ci.com/g/yoanm/PhpUnitExtended/?branch=master)

[![Travis Build Status](https://img.shields.io/travis/yoanm/PhpUnitExtended/master.svg?label=travis)](https://travis-ci.org/yoanm/PhpUnitExtended) [![PHP Versions](https://img.shields.io/badge/php-5.5%20%2F%205.6%20%2F%207.0-8892BF.svg)](https://php.net/)

[![Latest Stable Version](https://img.shields.io/packagist/v/yoanm/php-unit-extended.svg)](https://packagist.org/packages/yoanm/php-unit-extended)

Php library to extend PhpUnit
> :information_source: **See [Tests strategy compliance](./TESTS_STRATEGY_COMPLIANCE.md)**

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
