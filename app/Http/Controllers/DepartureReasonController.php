<?php

namespace App\Http\Controllers;

use App\Constants\Constants;
use App\Http\Requests\DepartureReason\CreateDepartureReasonRequest;
use App\Http\Requests\DepartureReason\UpdateDepartureReasonRequest;
use App\Models\DepartureReason;
use App\Services\DepartureReasonService;
use App\Services\HelperService;
use Diglactic\Breadcrumbs\Breadcrumbs;
use Exception;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Redirect;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class DepartureReasonController extends Controller implements HasMiddleware
{
    protected DepartureReasonService $departureReasonService;

    public function __construct(DepartureReasonService $departureReasonService)
    {
        $this->departureReasonService = $departureReasonService;
    }

    public static function middleware(): array
    {
        return [
            new Middleware('permission:can-create-departure-reason', only: ['store', 'storeDepartureReason']),
            new Middleware('permission:can-edit-departure-reason', only: ['update', 'changeStatus']),
            new Middleware('permission:can-delete-departure-reason', only: ['destroy']),
            new Middleware('permission:can-view-departure-reason', only: ['index', 'getDepartureReasons']),
        ];
    }

    public function index()
    {
        $breadcrumbs = Breadcrumbs::generate('departureReasons');
        $departureReasons = $this->departureReasonService->getDepartureReasons();
        $responseData = [
            'departureReasons' => $departureReasons,
            'breadcrumbs' => $breadcrumbs,
            'pageTitle' => 'Departure Reasons',
        ];
        return Inertia::render('DepartureReason/Index', $responseData);
    }

    public function store(CreateDepartureReasonRequest $request)
    {
        $validatedData = $request->validated();
        $departureReason = $this->departureReasonService->createDepartureReason($validatedData);
        if($departureReason){
            try{
                $this->departureReasonService->syncDepartureReasonAcrossCompanies($departureReason);
            }catch(Exception $e){
                HelperService::captureException($e);
            }
        }
        $status = $departureReason ? Constants::SUCCESS : Constants::ERROR;
        $message = $departureReason ? 'Departure Reason is created successfully' : 'Departure Reason could not be created';
        return Redirect::route('departure-reasons.index')->with($status, $message);
    }

    public function update(UpdateDepartureReasonRequest $request, DepartureReason $departureReason)
    {
        $validatedData = $request->validated();
        $isUpdated = $this->departureReasonService->update($departureReason, $validatedData);
        if($isUpdated){
            try{
                $this->departureReasonService->syncDepartureReasonAcrossCompanies($departureReason);
            }catch(Exception $e){
                HelperService::captureException($e);
            }
        }
        $status = $isUpdated ? Constants::SUCCESS : Constants::ERROR;
        $message = $isUpdated ? 'Departure Reason is updated successfully' : 'Departure Reason could not be updated';
        return Redirect::route('departure-reasons.index')->with($status, $message);
    }

    public function destroy(DepartureReason $departureReason)
    {
        $isDeleted = $this->departureReasonService->deleteDepartureReason($departureReason);
        if($isDeleted){
            try{
                $this->departureReasonService->syncDepartureReasonDeleteAcrossCompanies($departureReason);
            }catch(Exception $e){
                HelperService::captureException($e);
            }
        }
        $status = $isDeleted ? Constants::SUCCESS : Constants::ERROR;
        $message = $isDeleted ? 'Departure Reason is deleted successfully' : 'Departure Reason could not be deleted';
        return Redirect::route('departure-reasons.index')->with($status, $message);
    }

    public function changeStatus(Request $request, DepartureReason $departureReason)
    {
        $departureReason = $this->departureReasonService->changeStatus($departureReason, $request->is_active);
        if($departureReason){
            try{
                $this->departureReasonService->syncDepartureReasonAcrossCompanies($departureReason);
            }catch(Exception $e){
                HelperService::captureException($e);
            }
        }
        $status = $departureReason ? Constants::SUCCESS : Constants::ERROR;
        $message = $departureReason ? ($departureReason->is_active ? 'Departure Reason is activated' : 'Departure Reason is deactivated') : 'Departure Reason status could not be changed';
        return Redirect::route('departure-reasons.index')->with($status, $message);
    }
}
