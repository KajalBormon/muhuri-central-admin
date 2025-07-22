<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Location\District;
use App\Models\Location\Division;
use App\Models\Location\Upazila;
use App\Services\LocationService;
use Illuminate\Http\JsonResponse;

class LocationController extends Controller
{
    private LocationService $locationService;

    public function __construct(LocationService $locationService)
    {
        $this->locationService = $locationService;
    }

    public function division(): JsonResponse
    {
        $divisions = $this->locationService->getAllDivision();
        return response()->json($divisions);
    }

    public function districtByDivision(Division $division): JsonResponse
    {
        $districts = $this->locationService->getDistrictByDivision($division);
        return response()->json($districts);
    }

    public function upazilaByDistrict(District $district): JsonResponse
    {
        $upazilas = $this->locationService->getUpazilaByDistrict($district);
        return response()->json($upazilas);
    }


    public function unionByUpazila(Upazila $upazila): JsonResponse
    {
        $unions = $this->locationService->getUnionByUpazila($upazila);
        return response()->json($unions);
    }

    public function locations(): JsonResponse
    {
        $division = $this->locationService->getAllDivision();
        $district = $this->locationService->getAllDistrict();
        $upazila = $this->locationService->getAllUpazila();
        $locations = [
            'division' => $division,
            'district' => $district,
            'upazila' => $upazila,
        ];
        return response()->json($locations);
    }
}
