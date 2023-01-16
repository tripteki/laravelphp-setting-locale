<?php

namespace Tripteki\SettingLocale\Drivers;

use Tripteki\SettingLocale\Models\Admin\Language;
use Tripteki\SettingLocale\Observers\TranslationDriverObserver;
use Illuminate\Translation\FileLoader as Loader;

class DatabaseLoader extends Loader
{
    /**
     * @param string $locale
     * @param string $group
     * @param string|null $namespace
     * @return array
     */
    public function load($locale, $group, $namespace = null)
    {
        $translationDatabase = [];

        if ($model = Language::find($locale)) {

            $translationDatabase = (new TranslationDriverObserver())->cache($model->translations);
        }

        if ($group === "*" && $namespace === "*") {

            return array_replace_recursive($this->loadJsonPaths($locale), $translationDatabase);
        }

        if (is_null($namespace) || $namespace === "*") {

            return array_replace_recursive($this->loadPath($this->path, $locale, $group), $translationDatabase[$group] ?? []);
        }

        return $this->loadNamespaced($locale, $group, $namespace);
    }
};
