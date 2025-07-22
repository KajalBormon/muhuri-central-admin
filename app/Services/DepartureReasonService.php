<?php

namespace App\Services;

use App\Services\APIService\Muhuri\MuhuriService;
use App\Services\Company\CompanyService;
use Illuminate\Support\Str;
use App\Models\DepartureReason;
use Illuminate\Support\Facades\DB;

class DepartureReasonService extends BaseModelService
{
    protected CompanyService $companyService;
    protected MuhuriService $muhuriService;

    public function __construct(CompanyService $companyService, MuhuriService $muhuriService)
    {
        $this->companyService = $companyService;
        $this->muhuriService = $muhuriService;
    }

    public function model(): string
    {
        return DepartureReason::class;
    }

     public function getDepartureReasons($isActive = null)
    {
        return $isActive ? $this->model()::where('is_active', true)->get() : $this->model()::all();
    }

    public function createDepartureReason($validatedData)
    {
        $validatedData['slug'] = Str::slug($validatedData['name']);
        $departureReason = $this->create($validatedData);
        return $departureReason;
    }

    public function changeStatus(DepartureReason $departureReason, $isActive)
    {
        $isActive = ($isActive == true) ? false : true;
        $departureReason->is_active = $isActive;
        $departureReason->save();
        return $departureReason;
    }

    public function deleteDepartureReason(DepartureReason $departureReason)
    {
        return DB::transaction(function () use ($departureReason) {
            $departureReason->name = $departureReason->name . '-deleted' .'-' . $departureReason->id;
            $departureReason->slug = $departureReason->slug . '-deleted' .'-' . $departureReason->id;
            $departureReason->deleted_by = auth()->user()->id;
            $departureReason->save();
            $departureReason->delete();
            return true;
        });
    }

    public function getActiveDepartureReasons($isActive = true)
    {
        return $this->model()::where('is_active', $isActive)->get();
    }

    public function syncDepartureReasons($company)
    {
        $departureReasons = $this->getActiveDepartureReasons();
        return $this->muhuriService->syncDepartureReasons($departureReasons, $company);
    }

    public function syncDepartureReasonAcrossCompanies(DepartureReason $departureReason)
    {
        $companies = $this->companyService->getCompanies();
        foreach ($companies as $company) {
            $this->muhuriService->syncDepartureReasons($departureReason, $company);
        }
    }

    public function syncDepartureReasonDeleteAcrossCompanies(DepartureReason $departureReason)
    {
        $companies = $this->companyService->getCompanies();
        foreach ($companies as $company) {
            $this->muhuriService->syncDepartureReasonDelete($departureReason, $company);
        }
    }
}
