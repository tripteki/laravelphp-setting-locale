<h1 align="center">Setting-Locale</h1>

This package provides is an implementation of setting locale in repository pattern for Lumen and Laravel.

Getting Started
---

Installation :

```
$ composer require tripteki/laravelphp-setting-locale
```

How to use it :

- Put `Tripteki\SettingLocale\Providers\SettingLocaleServiceProvider` to service provider configuration list.

- Put `Tripteki\SettingLocale\Traits\LocaleTrait` to auth's provider model.

- Put below to the middleware :

`"locale" => \Tripteki\SettingLocale\Http\Middleware\TranslationMiddleware::class`<br />

- Migrate.

```
$ php artisan migrate
```

- Sample :

```php
use Tripteki\SettingLocale\Contracts\Repository\Admin\ISettingLocaleLanguageRepository;
use Tripteki\SettingLocale\Contracts\Repository\Admin\ISettingLocaleTranslationRepository;
use Tripteki\SettingLocale\Contracts\Repository\ISettingLocaleRepository;

$languageRepository = app(ISettingLocaleLanguageRepository::class);
$translationRepository = app(ISettingLocaleTranslationRepository::class);

// $languageRepository->create([ "code" => "en", "locale" => "en-US", ]); //
// $languageRepository->delete("en"); //
// $languageRepository->update("en", [ "locale" => "en-UK", ]); //
// $languageRepository->get("en"); //
// $languageRepository->all(); //

// $translationRepository->create("en", [ "key" => "auth.throttle", "translate" => "Too many login attempts. Please try again in :seconds seconds.", ]); //
// $translationRepository->delete("en", "auth.throttle"); //
// $translationRepository->update("en", "auth.throttle", [ "key" => "auth.throttle", "translate" => "Too many login attempts. Please try again in :minutes minutes.", ]); //
// $translationRepository->get("en", "auth.throttle"); //
// $translationRepository->all("en"); //

$repository = app(ISettingLocaleRepository::class);
// $repository->setUser(...); //
// $repository->getUser(); //

// $repository->setLocale("en"); //
// $repository->getLocale(); //
// locale(); //
// $repository->translate("auth.throttle"); //
// trans("auth.throttle"); //
// __("auth.throttle"); //
```

Author
---

- Trip Teknologi ([@tripteki](https://linkedin.com/company/tripteki))
- Hasby Maulana ([@hsbmaulana](https://linkedin.com/in/hsbmaulana))
