<?php

namespace Tripteki\SettingLocale\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\Resources\Json\JsonResource;

class LanguageResource extends JsonResource
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $resource = parent::toArray($request);

        $resource["key"] = "locale";

        return $resource;
    }
};
