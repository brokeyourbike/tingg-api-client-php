# tingg-api-client

[![Latest Stable Version](https://img.shields.io/github/v/release/brokeyourbike/tingg-api-client-php)](https://github.com/brokeyourbike/tingg-api-client-php/releases)
[![Total Downloads](https://poser.pugx.org/brokeyourbike/tingg-api-client/downloads)](https://packagist.org/packages/brokeyourbike/tingg-api-client)
[![Maintainability](https://api.codeclimate.com/v1/badges/8ac5d505c23cc7f3bf96/maintainability)](https://codeclimate.com/github/brokeyourbike/tingg-api-client-php/maintainability)
[![Test Coverage](https://api.codeclimate.com/v1/badges/8ac5d505c23cc7f3bf96/test_coverage)](https://codeclimate.com/github/brokeyourbike/tingg-api-client-php/test_coverage)

Tingg API Client for PHP

## Installation

```bash
composer require brokeyourbike/tingg-api-client
```

## Usage

```php
use BrokeYourBike\Tingg\Client;
use BrokeYourBike\Tingg\Interfaces\ConfigInterface;

assert($config instanceof ConfigInterface);
assert($httpClient instanceof \GuzzleHttp\ClientInterface);

$apiClient = new Client($config, $httpClient);
```

## Authors
- [Ivan Stasiuk](https://github.com/brokeyourbike) | [Twitter](https://twitter.com/brokeyourbike) | [LinkedIn](https://www.linkedin.com/in/brokeyourbike) | [stasi.uk](https://stasi.uk)

## License
[Mozilla Public License v2.0](https://github.com/brokeyourbike/tingg-api-client-php/blob/main/LICENSE)
