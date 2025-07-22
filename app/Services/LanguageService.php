<?php

namespace App\Services;

use App\Models\Language;

class LanguageService extends BaseModelService
{
    public function model(): string
    {
        return Language::class;
    }

    public function getLanguages($isActive = true)
    {
        $languages = $this->model()::where('is_active', $isActive)->get();
        return $languages;
    }

    public function getLanguageByCode($locale)
    {
        $language = $this->model()::where('code', $locale)->first();
        return $language;
    }

    public function getLanguageOptions()
    {
        $languages = $this->getLanguages();
        $result = $languages->map(function ($language) {
            return [
                'name' => $language->name,
                'code' => $language->code
            ];
        });
        return $result->all();
    }
}
