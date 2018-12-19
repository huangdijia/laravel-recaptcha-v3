<?php

namespace Huangdijia\Recaptcha\Middleware;

use Closure;

class ReCaptcha
{
    /**
     * @param $request
     * @param \Closure $next
     * @param string $action
     * @param float $score
     * @param string $hostname
     * @return mixed
     */
    public function handle($request, Closure $next, $action = '', $score = 0.34, $hostname = '')
    {
        if (config('recaptcha-v3.enable', true)) {

            $hostname  = $hostname ?: $request->getHttpHost();
            $recaptcha = app('recaptcha')->setExpectedHostname($hostname);

            if ($action) {
                $recaptcha->setExpectedAction($action);
            }

            if ($score) {
                $recaptcha->setScoreThreshold($score);
            }

            $resp = $recaptcha->verify($request->input(config('recaptcha-v3.input_name', 'g-recaptcha-response')), $request->getClientIp());

            if (!$resp->isSuccess()) {
                abort(config('recaptcha-v3.response_code', 401), config('recaptcha-v3.response_message', 'Google ReCaptcha verify failure'));
            }
        }

        return $next($request);
    }

}
