<?php

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

if (! function_exists("locale"))
{
    /**
     * @return string
     */
    function locale()
    {
        if (Auth::check()) {

            return @Auth::user()->locale()->first()->code ?? App::getLocale();

        } else {

            return App::getLocale();
        }
    };
}
