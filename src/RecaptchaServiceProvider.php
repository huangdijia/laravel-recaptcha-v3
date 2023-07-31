<?php

declare(strict_types=1);
/**
 * This file is part of laravel-recaptcha-v3.
 *
 * @link     https://github.com/huangdijia/laravel-recaptcha-v3
 * @document https://github.com/huangdijia/laravel-recaptcha-v3/blob/main/README.md
 * @contact  huangdijia@gmail.com
 */
namespace Huangdijia\Recaptcha;

use Illuminate\Container\Container;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use ReCaptcha\ReCaptcha;

/**
 * Class RecaptchaServiceProvider.
 */
class RecaptchaServiceProvider extends ServiceProvider
{
    protected $defer = false;

    /**
     * Bootstrap the application events.
     */
    public function boot()
    {
        $this->bootConfig();

        // validator
        $this->app['validator']->extend('recaptcha', function ($attribute, $value, $parameters, $validator) {
            $app = Container::getInstance();
            /** @var ReCaptcha $recaptcha */
            $recaptcha = $app['recaptcha']->setExpectedHostname($app['request']->getHttpHost());

            if ($parameters[0] ?? '') {
                $recaptcha->setExpectedAction($parameters[0]);
            }

            if ($parameters[1] ?? '') {
                $recaptcha->setScoreThreshold($parameters[1]);
            }

            return $recaptcha->verify($value, $app['request']->getClientIp())->isSuccess();
        });

        $this->loadViewsFrom(__DIR__ . '/../views', 'recaptcha');

        // @recapcha_initjs(['site_key' => 'xxx', 'action' => 'action_name']);
        Blade::directive('recaptcha_initjs', function ($expression) {
            $expression = Blade::stripParentheses($expression) ?: '[]';
            $path = 'recaptcha::components.initjs';

            return "<?php echo \$__env->make('{$path}', {$expression}, \\Illuminate\\Support\\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>";
        });

        // @recapcha_field(['site_key' => 'xxx', 'name' => 'input_name']);
        Blade::directive('recaptcha_field', function ($expression) {
            $expression = Blade::stripParentheses($expression) ?: '[]';
            $path = 'recaptcha::components.field';

            return "<?php echo \$__env->make('{$path}', {$expression}, \\Illuminate\\Support\\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>";
        });
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->app->bind('recaptcha', fn ($app) => new ReCaptcha($app['config']['recaptcha.secret_key']));
    }

    /**
     * Get the services provided by the provider.
     * @return array
     */
    public function provides()
    {
        return [
            'recaptcha',
        ];
    }

    /**
     * Booting configure.
     */
    protected function bootConfig()
    {
        $config = __DIR__ . '/../config/recaptcha.php';

        $this->mergeConfigFrom($config, 'recaptcha');

        if ($this->app->runningInConsole()) {
            $this->publishes([$config => $this->app->basePath('config/recaptcha.php')], 'config');
        }
    }
}
