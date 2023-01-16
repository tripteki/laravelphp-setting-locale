<?php

namespace Tripteki\SettingLocale\Console\Commands;

use Tripteki\Helpers\Contracts\AuthModelContract;
use Tripteki\Helpers\Helpers\ProjectHelper;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Console\Command;

class InstallCommand extends Command
{
    /**
     * @var string
     */
    protected $signature = "adminer:install:setting:locale";

    /**
     * @var string
     */
    protected $description = "Install the setting locale stack";

    /**
     * @var \Tripteki\Helpers\Helpers\ProjectHelper
     */
    protected $helper;

    /**
     * @param \Tripteki\Helpers\Helpers\ProjectHelper $helper
     * @return void
     */
    public function __construct(ProjectHelper $helper)
    {
        parent::__construct();

        $this->helper = $helper;
    }

    /**
     * @return int
     */
    public function handle()
    {
        $this->call("adminer:install:setting");
        $this->installStack();

        return 0;
    }

    /**
     * @return int|null
     */
    protected function installStack()
    {
        (new Filesystem)->ensureDirectoryExists(base_path("routes/user"));
        (new Filesystem)->ensureDirectoryExists(base_path("routes/admin"));
        (new Filesystem)->ensureDirectoryExists(base_path("routes/user/setting"));
        (new Filesystem)->ensureDirectoryExists(base_path("routes/admin/setting"));
        (new Filesystem)->copy(__DIR__."/../../../stubs/routes/user/setting/locale.php", base_path("routes/user/setting/locale.php"));
        (new Filesystem)->copy(__DIR__."/../../../stubs/routes/admin/setting/locale.php", base_path("routes/admin/setting/locale.php"));
        $this->helper->putRoute("api.php", "user/setting/locale.php");
        $this->helper->putRoute("api.php", "admin/setting/locale.php");
        
        (new Filesystem)->ensureDirectoryExists(app_path("Http/Controllers/Setting/Locale"));
        (new Filesystem)->copyDirectory(__DIR__."/../../../stubs/app/Http/Controllers/Setting/Locale", app_path("Http/Controllers/Setting/Locale"));
        (new Filesystem)->ensureDirectoryExists(app_path("Http/Requests/Settings/Locales"));
        (new Filesystem)->copyDirectory(__DIR__."/../../../stubs/app/Http/Requests/Settings/Locales", app_path("Http/Requests/Settings/Locales"));
        (new Filesystem)->ensureDirectoryExists(app_path("Http/Controllers/Admin/Setting/Locale"));
        (new Filesystem)->copyDirectory(__DIR__."/../../../stubs/app/Http/Controllers/Admin/Setting/Locale", app_path("Http/Controllers/Admin/Setting/Locale"));
        (new Filesystem)->ensureDirectoryExists(app_path("Imports/Settings/Locales"));
        (new Filesystem)->copyDirectory(__DIR__."/../../../stubs/app/Imports/Settings/Locales", app_path("Imports/Settings/Locales"));
        (new Filesystem)->ensureDirectoryExists(app_path("Exports/Settings/Locales"));
        (new Filesystem)->copyDirectory(__DIR__."/../../../stubs/app/Exports/Settings/Locales", app_path("Exports/Settings/Locales"));
        (new Filesystem)->ensureDirectoryExists(app_path("Http/Requests/Admin/Settings/Locales"));
        (new Filesystem)->copyDirectory(__DIR__."/../../../stubs/app/Http/Requests/Admin/Settings/Locales", app_path("Http/Requests/Admin/Settings/Locales"));
        (new Filesystem)->ensureDirectoryExists(app_path("Http/Responses"));

        $this->helper->putTrait($this->helper->classToFile(get_class(app(AuthModelContract::class))), \Tripteki\SettingLocale\Traits\LocaleTrait::class);
        $this->helper->putMiddleware(null, "locale", \Tripteki\SettingLocale\Http\Middleware\TranslationMiddleware::class);

        $this->info("Adminer Setting Locale scaffolding installed successfully.");
    }
};
