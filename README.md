# Google reCaptcha v3 for Laravel 5.6+

[![Latest Stable Version](https://poser.pugx.org/huangdijia/recaptcha-v3/version.png)](https://packagist.org/packages/huangdijia/recaptcha-v3)
[![Total Downloads](https://poser.pugx.org/huangdijia/recaptcha-v3/d/total.png)](https://packagist.org/packages/huangdijia/recaptcha-v3)

## Installation

To install, simply add it
to your `composer.json` file:

```json
{
    "require": {
        "huangdijia/recaptcha-v3": "~1.0"
    }
}
```

And run composer to update your dependencies:

```bash
composer update
```

Or you can simply run

```bash
composer require huangdijia/recaptcha-v3
```

Publish configuration file to your `config` folder with command:

    php artisan vendor:publish --provider="Huangdijia\Recaptcha\RecaptchaServiceProvider" --tag=config

## Usage

Use as regular validation rule `recaptcha:{ACTION},{SCORE}` like:

```php
Validator::make($request->all(), [
    'g-recaptcha-response' => 'required|recaptcha:register,0.5'
]);
```