<?php

namespace Huangdijia\Recaptcha;

use Illuminate\Support\ServiceProvider;
use ReCaptcha\ReCaptcha;

/**
 * Class RecaptchaServiceProvider
 * @package Huangdijia\Recaptcha
 */
class RecaptchaServiceProvider extends ServiceProvider
{
    protected $defer = true;

    /**
     * Bootstrap the application events.
     */
    public function boot()
    {
        $app = $this->app;

        $this->bootConfig();

        $app['validator']->extend('recaptcha', function ($attribute, $value, $parameters, $validator) use ($app) {
            $recaptcha = $app['recaptcha']->setExpectedHostname($app['request']->getHttpHost());

            if ($parameters[0] ?? '') {
                $recaptcha->setExpectedAction($parameters[0]);
            }

            if ($parameters[1] ?? '') {
                $recaptcha->setScoreThreshold($parameters[1]);
            }

            return $recaptcha->verify($value, $app['request']->getClientIp())->isSuccess();
        });
    }

    /**
     * Booting configure.
     */
    protected function bootConfig()
    {
        $path = __DIR__ . '/../config/recaptcha-v3.php';

        $this->mergeConfigFrom($path, 'recaptcha');

        if (function_exists('config_path')) {
            $this->publishes([$path => config_path('recaptcha-v3.php')], 'config');
        }
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->app->singleton('recaptcha', function ($app) {
            return new ReCaptcha($app['config']['recaptcha.secret_key']);
        });
    }

    /**
     * Get the services provided by the provider.
     * @return array
     */
    public function provides()
    {
        return ['recaptcha'];
    }
}
