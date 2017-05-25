<?php

namespace JellyBool\Translug;

use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;

class TranslugServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('translug', function () {
            if (!empty(config('services.youdao.appKey'))) {
                $config = [
                    'appKey' => config('services.youdao.appKey'),
                    'appSecret' => config('services.youdao.appSecret')
                ];
            } else {
                $config = [
                    'keyfrom' => config('services.youdao.from'),
                    'key' => config('services.youdao.key')
                ];
            }

            return new Translation(new Client(), $config);
        });
    }
}
