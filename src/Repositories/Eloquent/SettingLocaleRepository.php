<?php

namespace Tripteki\SettingLocale\Repositories\Eloquent;

use Error;
use Exception;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Tripteki\SettingLocale\Http\Resources\LanguageResource;
use Tripteki\Repository\AbstractRepository;
use Tripteki\SettingLocale\Scopes\LocaleStrictScope;
use Tripteki\SettingLocale\Events\Localing;
use Tripteki\SettingLocale\Events\Localed;
use Tripteki\Setting\Contracts\Repository\ISettingRepository;
use Tripteki\SettingLocale\Contracts\Repository\ISettingLocaleRepository;
use Tripteki\SettingLocale\Contracts\Repository\Admin\ISettingLocaleLanguageRepository;
use Tripteki\SettingLocale\Contracts\Repository\Admin\ISettingLocaleTranslationRepository;

class SettingLocaleRepository extends AbstractRepository implements ISettingLocaleRepository
{
    /**
     * @var string
     */
    protected $space;

    /**
     * @var \Tripteki\Setting\Contracts\Repository\ISettingRepository
     */
    protected $setting;

    /**
     * @var \Tripteki\SettingLocale\Contracts\Repository\Admin\ISettingLocaleLanguageRepository
     */
    protected $language;

    /**
     * @var \Tripteki\SettingLocale\Contracts\Repository\Admin\ISettingLocaleTranslationRepository
     */
    protected $translation;

    /**
     * @param \Tripteki\Setting\Contracts\Repository\ISettingRepository $setting
     * @param \Tripteki\SettingLocale\Contracts\Repository\Admin\ISettingLocaleLanguageRepository $language
     * @param \Tripteki\SettingLocale\Contracts\Repository\Admin\ISettingLocaleTranslationRepository $translation
     * @return void
     */
    public function __construct(ISettingRepository $setting, ISettingLocaleLanguageRepository $language, ISettingLocaleTranslationRepository $translation)
    {
        $this->space = Str::beforeLast(LocaleStrictScope::space(null), ".");
        $this->setting = $setting;
        $this->language = $language;
        $this->translation = $translation;
    }

    /**
     * @return void
     */
    public function __destruct()
    {}

    /**
     * @return mixed
     */
    public function language()
    {
        $user = $this->user; $content = null;

        try {

            $content = @$user->locale()->first()->code;

        } catch (Error | Exception $throwable) {

            $content = null;
        }

        return $content;
    }

    /**
     * @param int|string $translation
     * @return mixed
     */
    public function translate($translation)
    {
        $user = $this->user; $content = null;

        try {

            $content = @$user->locale()->first()->load([ "translations" => function ($query) use ($translation) { return $query->where("key", $translation)->firstOrFail(); }, ])->translations->firstOrFail()->translate;

        } catch (Error | Exception $throwable) {

            $content = $translation;
        }

        return $content;
    }

    /**
     * @param int|string|null $identifier
     * @param array $data
     * @return mixed
     */
    public function update($identifier, $data)
    {
        $this->setting->setUser($this->getUser());

        $content = $this->setting->setup($this->space, $this->language->get($data["locale"])->getKey());

        event(new Localed($content));

        return new LanguageResource($content);
    }

    /**
     * @return mixed
     */
    public function getLocale()
    {
        return $this->language();
    }

    /**
     * @param string $language
     * @return mixed
     */
    public function setLocale($language)
    {
        return $this->update(null, [ "locale" => $language, ]);
    }
};
