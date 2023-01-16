<?php

namespace Tripteki\SettingLocale\Repositories\Eloquent\Admin;

use Error;
use Exception;
use Illuminate\Support\Facades\DB;
use Tripteki\SettingLocale\Models\Admin\Language;
use Tripteki\SettingLocale\Models\Admin\Translation;
use Tripteki\SettingLocale\Contracts\Repository\Admin\ISettingLocaleTranslationRepository;
use Tripteki\RequestResponseQuery\QueryBuilder;

class SettingLocaleTranslationRepository implements ISettingLocaleTranslationRepository
{
    /**
     * @param int|string $languageid
     * @param array $querystring|[]
     * @return mixed
     */
    public function all($languageid, $querystring = [])
    {
        $querystringed =
        [
            "limit" => $querystring["limit"] ?? request()->query("limit", 10),
            "current_page" => $querystring["current_page"] ?? request()->query("current_page", 1),
        ];
        extract($querystringed);

        $content = Language::findOrFail($languageid);
        $content = $content->setRelation("translations",
            QueryBuilder::for($content->translations())->
            defaultSort("key")->
            allowedSorts([ "key", "translate", ])->
            allowedFilters([ "key", "translate", ])->
            paginate($limit, [ "*", ], "current_page", $current_page)->appends(empty($querystring) ? request()->query() : $querystringed));
        $content = $content->loadCount("translations");

        return $content;
    }

    /**
     * @param int|string $languageid
     * @param int|string $translationid
     * @param array $querystring|[]
     * @return mixed
     */
    public function get($languageid, $translationid, $querystring = [])
    {
        $content = Language::findOrFail($languageid)->translations()->where("key", $translationid);
        $contented = $content->firstOrFail();

        return $contented;
    }

    /**
     * @param int|string $languageid
     * @param int|string $translationid
     * @param array $data
     * @return mixed
     */
    public function update($languageid, $translationid, $data)
    {
        $content = Language::findOrFail($languageid)->translations()->where("key", $translationid);
        $contented = $content->firstOrFail();

        DB::beginTransaction();

        try {

            $content->update($data);
            $contented = $content->firstOrFail();

            DB::commit();

        } catch (Exception $exception) {

            DB::rollback();
        }

        return $contented;
    }

    /**
     * @param int|string $languageid
     * @param array $data
     * @return mixed
     */
    public function create($languageid, $data)
    {
        $content = Language::findOrFail($languageid);

        DB::beginTransaction();

        try {

            $content = $content->translations()->create($data);

            DB::commit();

        } catch (Exception $exception) {

            DB::rollback();
        }

        return $content;
    }

    /**
     * @param int|string $languageid
     * @param int|string $translationid
     * @return mixed
     */
    public function delete($languageid, $translationid)
    {
        $content = Language::findOrFail($languageid)->translations()->where("key", $translationid);
        $contented = $content->firstOrFail();

        DB::beginTransaction();

        try {

            $content->delete();

            DB::commit();

        } catch (Exception $exception) {

            DB::rollback();
        }

        return $contented;
    }
};
