<?php

declare(strict_types=1);
/**
 * This file is part of laravel-recaptcha-v3.
 *
 * @link     https://github.com/huangdijia/laravel-recaptcha-v3
 * @document https://github.com/huangdijia/laravel-recaptcha-v3/blob/main/README.md
 * @contact  huangdijia@gmail.com
 */
namespace Huangdijia\Recaptcha\Middleware;

use Closure;
use Illuminate\Http\Request;

class ReCaptcha
{
    /**
     * @param Request $request
     * @param string $action
     * @param float $score
     * @param string $hostname
     * @return mixed
     */
    public function handle($request, Closure $next, $action = '', $score = 0.34, $hostname = '')
    {
        if (config('recaptcha.enable', true)) {
            $hostname = $hostname ?: $request->getHost();
            /** @var \ReCaptcha\ReCaptcha $recaptcha */
            $recaptcha = app('recaptcha')->setExpectedHostname($hostname);

            if ($action) {
                $recaptcha->setExpectedAction($action);
            }

            if ($score) {
                $recaptcha->setScoreThreshold($score);
            }

            $resp = $recaptcha->verify($request->input(config('recaptcha.input_name', 'g-recaptcha-response')), $request->getClientIp());

            if (! $resp->isSuccess()) {
                abort(config('recaptcha.response_code', 401), config('recaptcha.response_message', 'Google ReCaptcha Verify Fails'));
            }
        }

        return $next($request);
    }
}
