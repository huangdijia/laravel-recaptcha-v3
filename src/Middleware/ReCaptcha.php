<?php

namespace Huangdijia\Recaptcha\Middleware;

use Closure;
use Illuminate\Http\Request;

class ReCaptcha
{
    /**
     * @param Request $request
     * @param \Closure $next
     * @param string $action
     * @param float $score
     * @param string $hostname
     * @return mixed
     */
    public function handle($request, Closure $next, $action = '', $score = 0.34, $hostname = '')
    {
        if (config('recaptcha-v3.enable', true)) {

            $hostname  = $hostname ?: $request->getHost();
            $recaptcha = app('recaptcha-v3')->setExpectedHostname($hostname);

            if ($action) {
                $recaptcha->setExpectedAction($action);
            }

            if ($score) {
                $recaptcha->setScoreThreshold($score);
            }

            $resp = $recaptcha->verify($request->input(config('recaptcha-v3.input_name', 'g-recaptcha-response')), $request->getClientIp());

            if (!$resp->isSuccess()) {
                abort(config('recaptcha-v3.response_code', 401), config('recaptcha-v3.response_message', 'Google ReCaptcha Verify Fails'));
            }
        }

        if (config('recaptcha-v2.enable', true)) {

            $hostname  = $hostname ?: $request->getHost();
            $recaptcha = app('recaptcha-v2')->setExpectedHostname($hostname);

            if ($action) {
                $recaptcha->setExpectedAction($action);
            }

            if ($score) {
                $recaptcha->setScoreThreshold($score);
            }

            $resp = $recaptcha->verify($request->input(config('recaptcha-v2.input_name', 'g-recaptcha-response')), $request->getClientIp());

            if (!$resp->isSuccess()) {
                abort(config('recaptcha-v2.response_code', 401), config('recaptcha-v2.response_message', 'Google ReCaptcha Verify Fails'));
            }
        }

        return $next($request);
    }

}
