# Tanda
Laravel package for Tanda API

[![Codacy Badge](https://app.codacy.com/project/badge/Grade/fc6d5c6826f14df481d8db85151994a2)](https://www.codacy.com/gh/alvinmurimi/Tanda/dashboard?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=alvinmurimi/Tanda&amp;utm_campaign=Badge_Grade)
[![Latest Version](https://img.shields.io/github/release/alvinmurimi/tanda.svg?style=flat-square)](https://github.com/alvinmurimi/tanda/releases)
[![Issues](https://img.shields.io/github/issues/alvinmurimi/tanda.svg?style=flat-square)](https://github.com/alvinmurimi/tanda/issues)
[![Total Downloads](https://img.shields.io/packagist/dt/alvoo/tanda.svg?style=flat-square)](https://packagist.org/packages/alvoo/tanda)

This package helps you integrate Tanda payment APIs into your laravel app.

The following APIs can be integrated through the package:
- Airtime purchase
- Utility bill payments
- KPLC prepaid tokens purcase
- Airtime voucher purchase
- Pay TV subscriptions
- Transaction status
- Account balances

This package is based on Tanda's REST API which can be found here: [https://docs.tanda.co.ke/reference](https://docs.tanda.co.ke/reference)

## Installation
You can install this package via composer

```sh
composer require alvoo/tanda
```

## Configuration
After installing the package, run;
```
php artisan tanda:install
```
or 

```sh
php artisan vendor:publish
```
This will publish `config/tanda.php` file.
This file is where you will add Tanda API configurations. By default, the configuration is set to `sandbox` so update to 'live' if you're using live credentials.

In your app's `.env` add your Tanda credentials as follows:

```
TANDA_CLIENT_ID=[Client ID]
TANDA_CLIENT_SECRET=[Client Secret]
TANDA_ORG_ID=[Organization ID]
TANDA_ENV=[sandbox or live]
```

Don't forget to update the callback URLs in `config/tanda.php`

## Usage

Import `Tanda Facade`
```sh
use Tanda;
```
### Airtime Purchase (Pinless prepaid airtime)
You can use this API for direct airtime topups.
Accepted parameters:
1. String `Provider` - Service provider ID `SAFARICOM`, `AIRTEL`, `TELKOM`
2. String `MSISDN` - Phone number in international format
3. Integer `Amount` - Recharge amount(10 to 10000)
```sh
$topup = Tanda::pinlessAirtime("SAFARICOM", "254712345678", 100);
```
