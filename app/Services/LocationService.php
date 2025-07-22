<?php

namespace App\Services;

use App\Models\Location\District;
use App\Models\Location\Division;
use App\Models\Location\Union;
use App\Models\Location\Upazila;
use Illuminate\Support\Facades\Cache;

class LocationService
{
    public function getAllDivision()
    {
        $cacheKey = "all-divisions";
        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        $divisions = Division::select('id', 'bn_name as name')->get()->map(function ($division) {
            return [
                'value' => $division->id,
                'text' => $division->name
            ];
        });
        Cache::put($cacheKey, $divisions);

        return $divisions;
    }

    public function getAllDistrict()
    {
        $cacheKey = "all-districts";
        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        $districts = District::select('id', 'bn_name as name')->get();
        Cache::put($cacheKey, $districts);

        return $districts;
    }

    public function getDistrictByDivision($division)
    {
        $cacheKey = "districts-by-{$division->id}";
        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        $districts = $division->districts()->select('id', 'bn_name as name')->get()->map(function ($district) {
            return [
                'value' => $district->id,
                'text' => $district->name
            ];
        });
        Cache::put($cacheKey, $districts);
        return $districts;
    }

    public function getAllUpazila()
    {
        $cacheKey = "all-upazilas";
        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        $upazilas = Upazila::select('id', 'bn_name as name')->get();
        Cache::put($cacheKey, $upazilas);

        return $upazilas;
    }

    public function getUpazilaByDistrict($district)
    {
        $cacheKey = "upazilas-by-{$district->id}";
        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }
        $upazilas = $district->upazilas()->select('id', 'bn_name as name')->get()->map(function ($upazila) {
            return [
                'value' => $upazila->id,
                'text' => $upazila->name
            ];
        });
        Cache::put($cacheKey, $upazilas);

        return $upazilas;
    }

    public function getAllUnion($upazila)
    {
        $cacheKey = "all-unions";
        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }
        $unions = Union::select('id', 'bn_name as name')->get();
        Cache::put($cacheKey, $unions);
        return $unions;
    }

    public function getUnionByUpazila($upazila)
    {
        $cacheKey = "unions-by-{$upazila->id}";
        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        $unions = $upazila->unions()->select('id', 'bn_name as name')->get()->map(function ($union) {
            return [
                'value' => $union->id,
                'text' => $union->name
            ];
        });
        Cache::put($cacheKey, $unions);

        return $unions;
    }

    public function getUnion($id)
    {
        $cacheKey = "union-{$id}";
        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        $union = Union::find($id);
        Cache::put($cacheKey, $union);

        return $union;
    }

    public function getUpazila($id)
    {
        $cacheKey = "upazila-{$id}";
        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        $upazila = Upazila::find($id);
        Cache::put($cacheKey, $upazila);

        return $upazila;
    }

    public function getDistrict($id)
    {
        $cacheKey = "district-{$id}";
        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        $district = District::find($id);
        Cache::put($cacheKey, $district);

        return $district;
    }

    public function getDivision($id)
    {
        $cacheKey = "division-{$id}";
        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        $division = Division::find($id);
        Cache::put($cacheKey, $division);

        return $division;
    }
}
