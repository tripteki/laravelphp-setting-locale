<?php

use Illuminate\Support\Str;

return [

    "cache" => Str::slug(env("APP_NAME"), "_")."_translation",

];
