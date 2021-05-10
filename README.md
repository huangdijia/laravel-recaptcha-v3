# Google reCaptcha v3 for Laravel 5.6+

[![Latest Stable Version](https://poser.pugx.org/huangdijia/laravel-recaptcha-v3/version.png)](https://packagist.org/packages/huangdijia/laravel-recaptcha-v3)
[![Total Downloads](https://poser.pugx.org/huangdijia/laravel-recaptcha-v3/d/total.png)](https://packagist.org/packages/huangdijia/laravel-recaptcha-v3)

## Installation

To install, simply add it
to your `composer.json` file:

```json
{
    "require": {
        "huangdijia/laravel-recaptcha-v3": "^2.0"
    }
}
```

And run composer to update your dependencies:

```bash
composer update
```

Or you can simply run

```bash
composer require huangdijia/laravel-recaptcha-v3
```

Publish configuration file to your `config` folder with command:

```bash
php artisan vendor:publish --provider="Huangdijia\Recaptcha\RecaptchaServiceProvider" --tag=config
```

## Usage

### Forms

```php
// default
@recaptcha_field()

// custom
@recaptcha_field(['site_key'=>'your_key', 'name'=>'input_name'])
```

### Init Recaptcha Javascript

*Must add after `@recaptcha_field()`*

Recaptcha v3 works best when it is loaded on every page to get the most context about interactions. Therefore, add to your header or footer template:

```php
// default
@recaptcha_initjs()

// custom
@recaptcha_initjs(['site_key'=>'your_key', 'action' => 'action_name', 'name'=>'input_name'])
```

### Validation as regular validation rule

Use as regular validation rule `recaptcha:{ACTION},{SCORE},{HOSTNAME}` like:

```php
Validator::make($request->all(), [
    'g-recaptcha-response' => 'required|recaptcha:register,0.5,www.a.com',
    // or
    // 'g-recaptcha-response' => 'required|recaptcha',
]);
```

### Validation as middleware

Set `$routeMiddleware`

```php
    $routeMiddleware = [
        // ...
        'recaptcha' => Huangdijia\Recaptcha\Middleware\ReCaptcha::class,
    ];
```

Use with route

```php
Route::get('/path')->middleware('recaptcha');
Route::get('/path')->middleware('recaptcha:{ACTION},{SCORE},{HOSTNAME}');
```
