<?php

namespace Tripteki\SettingLocale\Scopes;

use Tripteki\Setting\Scopes\StrictScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Scope as IScope;

class LocaleStrictScope
{
    /**
     * @var string
     */
    public static $space = "locale";

    /**
     * @param string $content
     * @return string
     */
    public static function space($content)
    {
        return StrictScope::$space.".".static::$space.".".$content;
    }
};
