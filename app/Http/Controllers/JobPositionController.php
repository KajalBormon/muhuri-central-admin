<?php

namespace App\Http\Controllers;

use App\Constants\Constants;
use App\Http\Controllers\Controller;
use App\Http\Requests\JobPosition\CreateJobPositionRequest;
use App\Http\Requests\JobPosition\UpdateJobPositionRequest;
use App\Models\JobPosition;
use App\Services\HelperService;
use App\Services\JobPositionService;
use Diglactic\Breadcrumbs\Breadcrumbs;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class JobPositionController extends Controller implements HasMiddleware
{
    protected JobPositionService $jobPositionService;

    public function __construct(JobPositionService $jobPositionService)
    {
        $this->jobPositionService = $jobPositionService;
    }

    public static function middleware(): array
    {
        return [
            new Middleware('permission:can-create-job-position', only: ['store', 'storeJobPosition']),
            new Middleware('permission:can-edit-job-position', only: ['update', 'changeStatus']),
            new Middleware('permission:can-delete-job-position', only: ['destroy']),
            new Middleware('permission:can-view-job-position', only: ['index', 'getJobPositions']),
        ];
    }

    public function index()
    {
        $breadcrumbs = Breadcrumbs::generate('jobPositions');
        $jobPositions = $this->jobPositionService->getJobPositions();
        $responseData = [
            'jobPositions' => $jobPositions,
            'breadcrumbs' => $breadcrumbs,
            'pageTitle' => 'Job Positions',
        ];
        return Inertia::render('JobPosition/Index', $responseData);
    }

    public function store(CreateJobPositionRequest $request)
    {
        $validatedData = $request->validated();
        $jobPosition = $this->jobPositionService->createJobPosition($validatedData);
        if($jobPosition){
            try{
                $this->jobPositionService->syncJobPositionAcrossCompanies($jobPosition);
            }catch(Exception $e){
                HelperService::captureException($e);
            }
        }
        $status = $jobPosition ? Constants::SUCCESS : Constants::ERROR;
        $message = $jobPosition ? 'Job position is created successfully' : 'Job position could not be created';
        return Redirect::route('job-positions.index')->with($status, $message);
    }

    public function update(UpdateJobPositionRequest $request, JobPosition $jobPosition)
    {
        $validatedData = $request->validated();
        $isUpdated = $this->jobPositionService->update($jobPosition, $validatedData);
        if($isUpdated){
            try{
                $this->jobPositionService->syncJobPositionAcrossCompanies($jobPosition);
            }catch(Exception $e){
                HelperService::captureException($e);
            }
        }
        $status = $isUpdated ? Constants::SUCCESS : Constants::ERROR;
        $message = $isUpdated ? 'Job position is updated successfully' : 'Job position could not be updated';
        return Redirect::route('job-positions.index')->with($status, $message);
    }

    public function destroy(JobPosition $jobPosition)
    {
        $jobPosition->deleted_by = auth()->id();
        $jobPosition->save();
        $isDeleted = $this->jobPositionService->deleteJobPosition($jobPosition);
        if($isDeleted){
            try{
                $this->jobPositionService->syncJobPositionDeleteAcrossCompanies($jobPosition);
            }catch(Exception $e){
                HelperService::captureException($e);
            }
        }
        $status = $isDeleted ? Constants::SUCCESS : Constants::ERROR;
        $message = $isDeleted ? 'Job position is deleted successfully' : 'Job position could not be deleted';
        return Redirect::route('job-positions.index')->with($status, $message);
    }

    public function changeStatus(Request $request, JobPosition $jobPosition)
    {
        $jobPosition = $this->jobPositionService->changeStatus($jobPosition, $request->is_active);
        if($jobPosition){
            try{
                $this->jobPositionService->syncJobPositionAcrossCompanies($jobPosition);
            }catch(Exception $e){
                HelperService::captureException($e);
            }
        }
        $status = $jobPosition ? Constants::SUCCESS : Constants::ERROR;
        $message = $jobPosition ? ($jobPosition->is_active ? 'Job position is activated' : 'Job position is deactivated') : 'Job position status could not be changed';
        return Redirect::route('job-positions.index')->with($status, $message);
    }
}
