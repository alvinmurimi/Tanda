# Tanda
Laravel package for Tanda payments API

[![Latest Version](https://img.shields.io/github/release/alvinmurimi/tanda.svg?style=flat-square)](https://github.com/alvinmurimi/tanda/releases)
[![Issues](https://img.shields.io/github/issues/alvinmurimi/tanda.svg?style=flat-square)](https://github.com/alvinmurimi/tanda/issues)
[![Total Downloads](https://img.shields.io/packagist/dt/alvoo/tanda.svg?style=flat-square)](https://packagist.org/packages/alvoo/tanda)

This package helps you integrate Tanda payment APIs into your laravel app.

The following APIs can be integrated through the package:
  - Airtime topup
  - Utility bill payments
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
```sh
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
The callback URLs **MUST** be updated in `config/tanda.php`.<br>
After updating your `.env` update the config:
```sh
php artisan config:cache
```

## Usage

Import `Tanda` Facade
```php
use Tanda;
```
### Airtime Purchase (Pinless prepaid airtime)
You can use this API for direct airtime topups.<br>
Accepted parameters:
1.  `Provider` - Service provider ID `SAFARICOM`, `AIRTEL`, `TELKOM`.
2.  `MSISDN` - Phone number in international format.
3.  `Amount` - Recharge amount (Should be between 10 and 10000).
```php
$topup = Tanda::pinlessAirtime("SAFARICOM", "254712345678", 100);
```
<!--If the request above is successful, a response similar to the one below is returned:
```json
{
  "id": "e57f4762-c58e-4a22-adc0-399fff308455",
  "status": "000001",
  "message": "Request received successfully.",
  "receiptNumber": null,
  "commandId": "TopupFlexi",
  "serviceProviderId": "SAFARICOM",
  "datetimeCreated": "2022-08-27 00:43:57.263 +0200",
  "datetimeLastModified": "2022-08-27 00:43:57.263 +0200",
  "datetimeCompleted": null,
  "requestParameters": [
    {
      "id": "accountNumber",
      "value": "254712345678",
      "label": "Phone No."
    },
    {
      "id": "amount",
      "value": "100",
      "label": "Amount"
    }
  ]
}
```-->

### Pay Tv
This method is used to make payments for TV subscriptions.<br>
Accepted parameters:
1.  `Provider` - Pay TV service provider(`GOTV`, `DSTV`, `ZUKU`, `STARTIMES`).
2.  `Account` - A valid box account number.
3.  `Amount` - Bill Amount (Should be between 10 and 20000).
```php
$pay = Tanda::payTV("GOTV", 201712256, 100);
```

### Bill Pay
Use this to make bill payments.<br>
Accepted parameters:
1.  `Provider` - Nairobi water (`NAIROBI_WTR`).
2.  `Account` - A Nairobi Wtr Meter Number.
3.  `Amount` - Bill value in KES (Should be between 100 and 35000).
```php
$bill = Tanda::billPay("NAIROBI_WTR", 25419321, 100);
```

### Airtime Voucher
This method is used to generate airtime voucher pins which you can use to recharge normally as you would with scratch cards.<br>
Accepted parameters:
1.  `Provider` - Service provider ID (`SAFARICOM`, `TELKOM`, `AIRTEL`).
3.  `Amount` - Voucher value.
    -  Airtel - 20, 50, 100, 250, 500, 1000.
    -  Safaricom - 20, 50, 100, 250, 500, 1000.
    -  Telkom - 20, 50, 100, 200, 500, 1000.
```php
$voucher = Tanda::voucherFix("SAFARICOM", 254712345678, 100);
```

### Balance
This method is used to query the API for account balances.<br>

```php
$balances = Tanda::balances();
```

### Transaction Status
Use this to query the transaction status API.<br>
Accepted parameters:
1.  `Transaction ID` - Unique request id returned during the initialization stage.
```php
$status = Tanda::query("ee92d1cb-625c-4e0a-8f28-8e86d929f9d7");
```

### Contributing
Pull requests and issues are welcome. Refer to [CONTRIBUTING.md](./CONTRIBUTING.md)

### Security Vulnerabilities
If you discover any security vulnerability, please send an e-mail to alvinmayende@gmail.com.

### License
This package is open-source software licensed under the [MIT license](LICENSE.md).
