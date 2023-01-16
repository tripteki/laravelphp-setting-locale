<?php

namespace Tripteki\SettingLocale\Observers;

use Illuminate\Support\Arr;
use Tripteki\SettingLocale\Models\Admin\Translation;
use Tripteki\SettingLocale\Http\Resources\TranslationResource;
use Illuminate\Support\Facades\Cache;

class TranslationDriverObserver
{
    /**
     * @param \Illuminate\Database\Eloquent\Collection $model
     * @return mixed
     */
    public function cache($model)
    {
        return Cache::rememberForever(config("translation.cache"), function () use ($model) {

            return Arr::undot(Arr::collapse(TranslationResource::collection($model)->resolve()));
        });
    }

    /**
     * @param \Tripteki\SettingLocale\Models\Admin\Translation $model
     * @return void
     */
    public function created(Translation $model)
    {
        Cache::forget(config("translation.cache"));
    }

    /**
     * @param \Tripteki\SettingLocale\Models\Admin\Translation $model
     * @return void
     */
    public function deleted(Translation $model)
    {
        Cache::forget(config("translation.cache"));
    }

    /**
     * @param \Tripteki\SettingLocale\Models\Admin\Translation $model
     * @return void
     */
    public function updated(Translation $model)
    {
        Cache::forget(config("translation.cache"));
    }

    /**
     * @param \Tripteki\SettingLocale\Models\Admin\Translation $model
     * @return void
     */
    public function restored(Translation $model)
    {
        Cache::forget(config("translation.cache"));
    }

    /**
     * @param \Tripteki\SettingLocale\Models\Admin\Translation $model
     * @return void
     */
    public function forceDeleted(Translation $model)
    {
        Cache::forget(config("translation.cache"));
    }
};
