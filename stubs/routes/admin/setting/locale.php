<?php

use App\Http\Controllers\Admin\Setting\Locale\LanguageAdminController;
use App\Http\Controllers\Admin\Setting\Locale\TranslationAdminController;
use Illuminate\Support\Facades\Route;

Route::prefix(config("adminer.route.admin"))->middleware(config("adminer.middleware.admin"))->group(function () {

    /**
     * Settings Locales.
     */
    Route::prefix("locales")->group(function () {

        Route::apiResource("languages", LanguageAdminController::class)->parameters([ "languages" => "code", ]);
        Route::apiResource("languages.translations", TranslationAdminController::class)->parameters([ "languages" => "code", "translations" => "key", ]);
    });
});
