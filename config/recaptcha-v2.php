<?php
return [
    'enable'           => env('GOOGLE_RECAPTCHA_V2_ENABLE', true),
    'site_key'         => env('GOOGLE_RECAPTCHA_V2_SITE_KEY', ''),
    'secret_key'       => env('GOOGLE_RECAPTCHA_V2_SECRET_KEY', ''),
    'input_name'       => env('GOOGLE_RECAPTCHA_V2_INPUT_NAME', 'g-recaptcha-response'),
    'response_code'    => env('GOOGLE_RECAPTCHA_V2_RESPONSE_CODE', 401),
    'response_message' => env('GOOGLE_RECAPTCHA_V2_RESPONSE_MESSAGE', 'Google ReCaptcha Verify Fails'),
];
