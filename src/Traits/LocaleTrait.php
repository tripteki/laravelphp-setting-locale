<?php

namespace Tripteki\SettingLocale\Traits;

use Tripteki\Setting\Models\Setting;
use Tripteki\SettingLocale\Models\Admin\Language;

trait LocaleTrait
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function locale()
    {
        return $this->hasOneThrough(Language::class, Setting::class, foreignKeyName($this), "code", keyName($this), "value");
    }
};
