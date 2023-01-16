<?php

namespace App\Http\Controllers\Admin\Setting\Locale;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Tripteki\SettingLocale\Contracts\Repository\Admin\ISettingLocaleLanguageRepository;
use App\Http\Requests\Admin\Settings\Locales\Languages\LanguageShowValidation;
use App\Http\Requests\Admin\Settings\Locales\Languages\LanguageStoreValidation;
use App\Http\Requests\Admin\Settings\Locales\Languages\LanguageUpdateValidation;
use App\Http\Requests\Admin\Settings\Locales\Languages\LanguageDestroyValidation;
use Tripteki\Helpers\Http\Controllers\Controller;

class LanguageAdminController extends Controller
{
    /**
     * @var \Tripteki\SettingLocale\Contracts\Repository\Admin\ISettingLocaleLanguageRepository
     */
    protected $languageRepository;

    /**
     * @param \Tripteki\SettingLocale\Contracts\Repository\Admin\ISettingLocaleLanguageRepository $languageRepository
     * @return void
     */
    public function __construct(ISettingLocaleLanguageRepository $languageRepository)
    {
        $this->languageRepository = $languageRepository;
    }

    /**
     * @OA\Get(
     *      path="/admin/locales/languages",
     *      tags={"Admin Locale Language"},
     *      summary="Index",
     *      @OA\Parameter(
     *          required=false,
     *          in="query",
     *          name="limit",
     *          description="Locale Language's Pagination Limit."
     *      ),
     *      @OA\Parameter(
     *          required=false,
     *          in="query",
     *          name="current_page",
     *          description="Locale Language's Pagination Current Page."
     *      ),
     *      @OA\Parameter(
     *          required=false,
     *          in="query",
     *          name="order",
     *          description="Locale Language's Pagination Order."
     *      ),
     *      @OA\Parameter(
     *          required=false,
     *          in="query",
     *          name="filter[]",
     *          description="Locale Language's Pagination Filter."
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Success."
     *      )
     * )
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $data = [];
        $statecode = 200;

        $data = $this->languageRepository->all();

        return iresponse($data, $statecode);
    }

    /**
     * @OA\Get(
     *      path="/admin/locales/languages/{code}",
     *      tags={"Admin Locale Language"},
     *      summary="Show",
     *      @OA\Parameter(
     *          required=true,
     *          in="path",
     *          name="code",
     *          description="Locale Language's Code."
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Success."
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Not Found."
     *      )
     * )
     *
     * @param \App\Http\Requests\Admin\Settings\Locales\Languages\LanguageShowValidation $request
     * @param string $code
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(LanguageShowValidation $request, $code)
    {
        $form = $request->validated();
        $data = [];
        $statecode = 200;

        $data = $this->languageRepository->get($code);

        return iresponse($data, $statecode);
    }

    /**
     * @OA\Post(
     *      path="/admin/locales/languages",
     *      tags={"Admin Locale Language"},
     *      summary="Store",
     *      @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/x-www-form-urlencoded",
     *              @OA\Schema(
     *                  @OA\Property(
     *                      property="code",
     *                      type="string",
     *                      description="Locale Language's Code."
     *                  ),
     *                  @OA\Property(
     *                      property="locale",
     *                      type="string",
     *                      description="Locale Language's Locale."
     *                  )
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Created."
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Unprocessable Entity."
     *      )
     * )
     *
     * @param \App\Http\Requests\Admin\Settings\Locales\Languages\LanguageStoreValidation $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(LanguageStoreValidation $request)
    {
        $form = $request->validated();
        $data = [];
        $statecode = 202;

        $data = $this->languageRepository->create($form);

        if ($data) {

            $statecode = 201;
        }

        return iresponse($data, $statecode);
    }

    /**
     * @OA\Put(
     *      path="/admin/locales/languages/{code}",
     *      tags={"Admin Locale Language"},
     *      summary="Update",
     *      @OA\Parameter(
     *          required=true,
     *          in="path",
     *          name="code",
     *          description="Locale Language's Code."
     *      ),
     *      @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/x-www-form-urlencoded",
     *              @OA\Schema(
     *                  @OA\Property(
     *                      property="locale",
     *                      type="string",
     *                      description="Locale Language's Locale."
     *                  )
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Created."
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Unprocessable Entity."
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Not Found."
     *      )
     * )
     *
     * @param \App\Http\Requests\Admin\Settings\Locales\Languages\LanguageUpdateValidation $request
     * @param string $code
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(LanguageUpdateValidation $request, $code)
    {
        $form = $request->validated();
        $data = [];
        $statecode = 202;

        $data = $this->languageRepository->update($code, [ "locale" => $form["locale"], ]);

        if ($data) {

            $statecode = 201;
        }

        return iresponse($data, $statecode);
    }

    /**
     * @OA\Delete(
     *      path="/admin/locales/languages/{code}",
     *      tags={"Admin Locale Language"},
     *      summary="Destroy",
     *      @OA\Parameter(
     *          required=true,
     *          in="path",
     *          name="code",
     *          description="Locale Language's Code."
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Success."
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Unprocessable Entity."
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Not Found."
     *      )
     * )
     *
     * @param \App\Http\Requests\Admin\Settings\Locales\Languages\LanguageDestroyValidation $request
     * @param string $code
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(LanguageDestroyValidation $request, $code)
    {
        $form = $request->validated();
        $data = [];
        $statecode = 202;

        $data = $this->languageRepository->delete($code);

        if ($data) {

            $statecode = 200;
        }

        return iresponse($data, $statecode);
    }
};
