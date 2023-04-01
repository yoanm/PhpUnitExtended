# PhpUnitExtended
[![License](https://img.shields.io/github/license/yoanm/PhpUnitExtended.svg)](https://github.com/yoanm/PhpUnitExtended)
[![Code size](https://img.shields.io/github/languages/code-size/yoanm/PhpUnitExtended.svg)](https://github.com/yoanm/PhpUnitExtended)
[![Dependabot Status](https://api.dependabot.com/badges/status?host=github\&repo=yoanm/PhpUnitExtended)](https://dependabot.com)

[![Scrutinizer Build Status](https://img.shields.io/scrutinizer/build/g/yoanm/PhpUnitExtended.svg?label=Scrutinizer\&logo=scrutinizer)](https://scrutinizer-ci.com/g/yoanm/PhpUnitExtended/build-status/master)
[![Scrutinizer Code Quality](https://img.shields.io/scrutinizer/g/yoanm/PhpUnitExtended/master.svg?logo=scrutinizer)](https://scrutinizer-ci.com/g/yoanm/PhpUnitExtended/?branch=master)
[![Codacy Badge](https://app.codacy.com/project/badge/Grade/8f39424add044b43a70bdb238e2f48db)](https://www.codacy.com/gh/yoanm/PhpUnitExtended/dashboard?utm_source=github.com\&utm_medium=referral\&utm_content=yoanm/PhpUnitExtended\&utm_campaign=Badge_Grade)

[![CI](https://github.com/yoanm/PhpUnitExtended/actions/workflows/CI.yml/badge.svg?branch=master)](https://github.com/yoanm/PhpUnitExtended/actions/workflows/CI.yml)
[![codecov](https://codecov.io/gh/yoanm/PhpUnitExtended/branch/master/graph/badge.svg?token=NHdwEBUFK5)](https://codecov.io/gh/yoanm/PhpUnitExtended)

[![Latest Stable Version](https://img.shields.io/packagist/v/yoanm/php-unit-extended.svg)](https://packagist.org/packages/yoanm/php-unit-extended)
[![Packagist PHP version](https://img.shields.io/packagist/php-v/yoanm/php-unit-extended.svg)](https://packagist.org/packages/yoanm/php-unit-extended)

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
