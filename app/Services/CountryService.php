<?php

namespace App\Services;


use App\Models\Country;

class CountryService extends BaseModelService
{
    public function model(): string
    {
        return Country::class;
    }

    public function getCountries()
    {
        $countries = $this->model()::all();
        return $countries;
    }
}
