<?php

namespace App\Http\Controllers;

use App\Services\FiscalYear\FiscalYearManagementService;
use App\Services\FiscalYear\FiscalYearService;
use App\Services\HelperService;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Diglactic\Breadcrumbs\Breadcrumbs;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Inertia\Response;
use App\Models\FiscalYear;
use App\Http\Requests\FiscalYear\CreateFiscalYearRequest;
use App\Http\Requests\FiscalYear\UpdateFiscalYearRequest;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;

class FiscalYearController extends Controller implements HasMiddleware
{
    public FiscalYearService $fiscalYearService;
    public FiscalYearManagementService $fiscalYearManagementService;

    public function __construct(FiscalYearService $fiscalYearService, FiscalYearManagementService $fiscalYearManagementService)
    {
        $this->fiscalYearService = $fiscalYearService;
        $this->fiscalYearManagementService = $fiscalYearManagementService;
    }

    public static function middleware(): array
    {
        return [
            new Middleware('check-fiscal-year.isEditable', only: ['edit', 'update']),
            new Middleware('permission:can-view-fiscal-year', only: ['index']),
            new Middleware('permission:can-create-fiscal-year', only: ['create', 'store']),
            new middleware('permission:can-edit-fiscal-year', only: ['edit', 'update', 'changeStatus', 'closeFiscalYear', 'startFiscalYear'])
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $breadcrumbs = Breadcrumbs::generate('fiscalYears');
        $fiscalYears = $this->fiscalYearService->all();
        $totalCount = count($fiscalYears);
        $responseData = [
            'fiscalYears' => $fiscalYears,
            'breadcrumbs' => $breadcrumbs,
            'totalCount' => $totalCount,
            'pageTitle' => "Fiscal Years ($totalCount)"
        ];
        return Inertia::render('FiscalYear/Index',$responseData);
    }

    /**
     * Show the form for creating a new resource.
     */

    public function create(): Response
    {
        $breadcrumbs = Breadcrumbs::generate('addFiscalYear');
        $responseData = [
            'breadcrumbs' => $breadcrumbs,
            'pageTitle' => "Add Fiscal Year"
        ];

        return Inertia::render('FiscalYear/Create', $responseData);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateFiscalYearRequest $request): RedirectResponse
    {
        $validateData = $request->validated();
        $fiscalYear =  $this->fiscalYearService->create($validateData);
        if($fiscalYear){
            try{
                $this->fiscalYearService->syncFiscalYearAcrossCompanies($fiscalYear);
            }catch(\Exception $e){
                HelperService::captureException($e);
            }
        }
        $status = $fiscalYear ? 'success' : 'error';
        $message = $fiscalYear ? 'Fiscal year created successfully' : 'Fiscal year could not be created';
        return Redirect::route('fiscal-years.index')->with($status, $message);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FiscalYear $fiscalYear): Response
    {
        $breadcrumbs = Breadcrumbs::generate('editFiscalYear', $fiscalYear);
        $responseData = [
            'fiscalYear' => $fiscalYear,
            'breadcrumbs' => $breadcrumbs,
            'pageTitle' => 'Edit Fiscal Year'
        ];

        return Inertia::render('FiscalYear/Create', $responseData);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFiscalYearRequest $request, FiscalYear $fiscalYear)
    {
        $validateData = $request->validated();
        $isUpdated = $this->fiscalYearService->update($fiscalYear, $validateData);
        if($isUpdated){
            try{
                $this->fiscalYearService->syncFiscalYearAcrossCompanies($fiscalYear);
            }catch(\Exception $e){
                HelperService::captureException($e);
            }
        }
        $status = $isUpdated ? 'success' : 'error';
        $message = $isUpdated ? 'Fiscal year updated successfully' : 'Fiscal year could not be updated';
        return Redirect::route('fiscal-years.index')->with($status, $message);
    }

    public function changeStatus(Request $request, FiscalYear $fiscalYear): RedirectResponse
    {
        $fiscalYear = $this->fiscalYearService->changeStatus($fiscalYear, $request->is_active);
        if($fiscalYear){
            try{
                $this->fiscalYearService->syncFiscalYearAcrossCompanies($fiscalYear);
            }catch(\Exception $e){
                HelperService::captureException($e);
            }
        }
        $status = $fiscalYear ? 'success' : 'error';
        $message = $fiscalYear ? ($fiscalYear->is_active ? 'Fiscal year status is activated' : 'Fiscal year status is deactivated') : 'Fiscal year status could not be changed';
        return redirect()->route('fiscal-years.index')->with($status, $message);
    }

    public function closeFiscalYear(FiscalYear $fiscalYear): RedirectResponse
    {
        if($fiscalYear->status != 'running'){
            $status = 'error';
            $message = 'Fiscal year is not running. So it can not be closed';
        }else{
            $fiscalYear = $this->fiscalYearManagementService->closeFiscalYear($fiscalYear);
            if($fiscalYear){
                try{
                    $this->fiscalYearService->syncFiscalYearAcrossCompanies($fiscalYear);
                }catch(\Exception $e){
                    HelperService::captureException($e);
                }
            }
            $status = $fiscalYear ? 'success' : 'error';
            $message = $fiscalYear ? 'Fiscal year closed successfully' : 'Fiscal year could not be closed';
        }
        return redirect()->route('fiscal-years.index')->with($status, $message);
    }

    public function startFiscalYear(FiscalYear $fiscalYear): RedirectResponse
    {
        $runningFiscalYear = $this->fiscalYearService->getRunningFiscalYear();
        if($runningFiscalYear){
            $status = 'error';
            $message = "Another fiscal year is running, so it can't be started";
        }else{
            $fiscalYear = $this->fiscalYearManagementService->startFiscalYear($fiscalYear);
            if($fiscalYear){
                try{
                    $this->fiscalYearService->syncFiscalYearAcrossCompanies($fiscalYear);
                }catch(\Exception $e){
                    HelperService::captureException($e);
                }
            }
            $status = $fiscalYear ? 'success' : 'error';
            $message = $fiscalYear ? 'Fiscal year started successfully' : 'Fiscal year could not be started';
        }
        return redirect()->route('fiscal-years.index')->with($status, $message);
    }
}
