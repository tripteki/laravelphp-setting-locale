<?php

namespace Tripteki\SettingLocale\Providers;

use Illuminate\Translation\Translator;
use Tripteki\SettingLocale\Models\Admin\Translation;
use Tripteki\SettingLocale\Observers\TranslationDriverObserver;
use Tripteki\SettingLocale\Drivers\DatabaseLoader;
use Illuminate\Translation\TranslationServiceProvider as ServiceProvider;

class TranslationServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function register()
    {
        $this->registerLoader();

        $this->app->singleton("translator", function ($app) {

            $loader = $app["translation.loader"];

            $locale = locale();

            $trans = new Translator($loader, $locale);

            $trans->setFallback($app->getFallbackLocale());

            return $trans;
        });
    }

    /**
     * @return void
     */
    public function boot()
    {
        $this->dataEventListener();
    }

    /**
     * @return void
     */
    protected function registerLoader()
    {
        $this->app->singleton("translation.loader", function ($app) {

            return new DatabaseLoader($app["files"], $app["path.lang"]);
        });
    }

    /**
     * @return void
     */
    public function dataEventListener()
    {
        Translation::observe(TranslationDriverObserver::class);
    }
};
