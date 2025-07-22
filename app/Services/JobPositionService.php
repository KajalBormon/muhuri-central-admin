<?php

namespace App\Services;

use App\Models\JobPosition;
use App\Services\APIService\Muhuri\MuhuriService;
use App\Services\BaseModelService;
use App\Services\Company\CompanyService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class JobPositionService extends BaseModelService
{
    private MuhuriService $muhuriService;
    private CompanyService $companyService;

    public function __construct(MuhuriService $muhuriService, CompanyService $companyService)
    {
        $this->muhuriService = $muhuriService;
        $this->companyService = $companyService;
    }

    public function model(): string
    {
        return JobPosition::class;
    }

    public function getJobPositions($isActive = false)
    {
        return $isActive ? $this->model()::where('is_active', true)->get() : $this->model()::all();
    }

    public function createJobPosition($validatedData)
    {
        $validatedData['slug'] = Str::slug($validatedData['name']);
        $jobPosition = $this->create($validatedData);
        return $jobPosition;
    }

    public function changeStatus(JobPosition $jobPosition, $isActive)
    {
        $isActive = ($isActive == true) ? false : true;
        $jobPosition->is_active = $isActive;
        $jobPosition->save();
        return $jobPosition;
    }

    public function getActiveJobPositions($isActive = true)
    {
        $jobPositions = JobPosition::where('is_active', $isActive)->get();
        return $jobPositions->isEmpty() ? false : $jobPositions;
    }

    public function syncJobPositions($company)
    {
        $jobPositions = $this->getActiveJobPositions();
        return $this->muhuriService->syncJobPositions($jobPositions, $company);
    }

    public function syncJobPositionAcrossCompanies(JobPosition $jobPosition)
    {
        $companies = $this->companyService->getCompanies();
        foreach ($companies as $company) {
            $this->muhuriService->syncJobPositions($jobPosition, $company);
        }
    }

    public function syncJobPositionDeleteAcrossCompanies(JobPosition $jobPosition)
    {
        $companies = $this->companyService->getCompanies();
        foreach ($companies as $company) {
            $this->muhuriService->syncJobPositionDelete($jobPosition, $company);
        }
    }

    public function deleteJobPosition(JobPosition $jobPosition)
    {
        return DB::transaction(function () use ($jobPosition) {
            $jobPosition->delete();
            $jobPosition->name = $jobPosition->name . '-deleted' .'-' . $jobPosition->id;
            $jobPosition->slug = $jobPosition->slug . '-deleted' .'-' . $jobPosition->id;
            $jobPosition->deleted_by = auth()->user()->id;
            $jobPosition->save();
            return true;
        });
    }
}
