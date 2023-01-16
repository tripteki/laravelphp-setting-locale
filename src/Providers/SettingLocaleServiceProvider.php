<?php

namespace Tripteki\SettingLocale\Providers;

use Tripteki\SettingLocale\Console\Commands\InstallCommand;
use Tripteki\Repository\Providers\RepositoryServiceProvider as ServiceProvider;

class SettingLocaleServiceProvider extends ServiceProvider
{
    /**
     * @var array
     */
    protected $repositories =
    [
        \Tripteki\SettingLocale\Contracts\Repository\ISettingLocaleRepository::class => \Tripteki\SettingLocale\Repositories\Eloquent\SettingLocaleRepository::class,
        \Tripteki\SettingLocale\Contracts\Repository\Admin\ISettingLocaleLanguageRepository::class => \Tripteki\SettingLocale\Repositories\Eloquent\Admin\SettingLocaleLanguageRepository::class,
        \Tripteki\SettingLocale\Contracts\Repository\Admin\ISettingLocaleTranslationRepository::class => \Tripteki\SettingLocale\Repositories\Eloquent\Admin\SettingLocaleTranslationRepository::class,
    ];

    /**
     * @var bool
     */
    public static $runsMigrations = true;

    /**
     * @return bool
     */
    public static function shouldRunMigrations()
    {
        return static::$runsMigrations;
    }

    /**
     * @return void
     */
    public static function ignoreMigrations()
    {
        static::$runsMigrations = false;
    }

    /**
     * @return void
     */
    public function boot()
    {
        parent::boot();

        $this->registerPublishers();
        $this->registerConfigs();
        $this->registerCommands();
        $this->registerMigrations();
    }

    /**
     * @return void
     */
    protected function registerConfigs()
    {
        $this->mergeConfigFrom(__DIR__."/../../config/translation.php", "translation");
    }

    /**
     * @return void
     */
    protected function registerCommands()
    {
        if (! $this->app->isProduction() && $this->app->runningInConsole()) {

            $this->commands(
            [
                InstallCommand::class,
            ]);
        }
    }

    /**
     * @return void
     */
    protected function registerMigrations()
    {
        if ($this->app->runningInConsole() && static::shouldRunMigrations()) {

            $this->loadMigrationsFrom(__DIR__."/../../database/migrations");
        }
    }

    /**
     * @return void
     */
    protected function registerPublishers()
    {
        $this->publishes(
        [
            __DIR__."/../../config/translation.php" => config_path("translation.php"),
        ],

        "tripteki-laravelphp-setting-locale");

        if (! static::shouldRunMigrations()) {

            $this->publishes(
            [
                __DIR__."/../../database/migrations" => database_path("migrations"),
            ],

            "tripteki-laravelphp-setting-locale-migrations");
        }

        $this->publishes(
        [
            __DIR__."/../../stubs/tests/Feature/Setting/Locale/LocaleTest.stub" => base_path("tests/Feature/Setting/Locale/LocaleTest.php"),
        ],

        "tripteki-laravelphp-setting-locale-tests");
    }
};
