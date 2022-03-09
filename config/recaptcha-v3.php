<?php

declare(strict_types=1);
/**
 * This file is part of http-client.
 *
 * @link     https://github.com/huangdijia/laravel-recaptcha-v3
 * @document https://github.com/huangdijia/laravel-recaptcha-v3/2.x/main/README.md
 * @contact  huangdijia@gmail.com
 */
return [
    'enable' => env('GOOGLE_RECAPTCHA_ENABLE', true),
    'site_key' => env('GOOGLE_RECAPTCHA_SITE_KEY', ''),
    'secret_key' => env('GOOGLE_RECAPTCHA_SECRET_KEY', ''),
    'input_name' => env('GOOGLE_RECAPTCHA_INPUT_NAME', 'g-recaptcha-response'),
    'response_code' => env('GOOGLE_RECAPTCHA_RESPONSE_CODE', 401),
    'response_message' => env('GOOGLE_RECAPTCHA_RESPONSE_MESSAGE', 'Google ReCaptcha Verify Fails'),
];
