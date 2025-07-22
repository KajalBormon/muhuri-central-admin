<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaymentMethod\CreatePaymentMethodRequest;
use App\Http\Requests\PaymentMethod\UpdatePaymentMethodRequest;
use App\Models\PaymentMethod;
use App\Services\HelperService;
use Exception;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Services\PaymentMethodService;
use Diglactic\Breadcrumbs\Breadcrumbs;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Hash;

class PaymentMethodController extends Controller implements HasMiddleware
{
    protected PaymentMethodService $paymentMethodService;

    public function __construct(PaymentMethodService $paymentMethodService)
    {
        $this->paymentMethodService = $paymentMethodService;
    }

    public static function middleware(): array
    {
        return [
            new Middleware('permission:can-view-payment-method', only: ['index']),
            new Middleware('permission:can-create-payment-method', only: ['create','store']),
            new Middleware('permission:can-edit-payment-method', only: ['edit','update']),
            new Middleware('permission:can-delete-payment-method', only: ['destroy']),
        ];
    }

    public function index()
    {
        $breadcrumbs = Breadcrumbs::generate('paymentMethods');
        $paymentMethods = $this->paymentMethodService->getPaymentMethods();
        $responseData = [
            'paymentMethods' => $paymentMethods,
            'breadcrumbs' => $breadcrumbs,
            'pageTitle' => 'Payment Methods'
        ];

        return Inertia::render('PaymentMethod/Index', $responseData);
    }

    public function create()
    {
        $breadcrumbs = Breadcrumbs::generate('addPaymentMethod');
        $responseData = [
            'breadcrumbs' => $breadcrumbs,
            'pageTitle' => 'Add Payment Method'
        ];
        return Inertia::render('PaymentMethod/Create', $responseData);
    }

    public function store(CreatePaymentMethodRequest $request)
    {
        $validatedData = $request->validated();
        if(isset($validatedData['password'])) {
            $validatedData['password'] = Hash::make($validatedData['password']);
        }
        $paymentMethod = $this->paymentMethodService->create($validatedData);
        if($paymentMethod){
            try{
                $this->paymentMethodService->syncPaymentMethodAcrossCompanies($paymentMethod);
            }catch(Exception $e){
                HelperService::captureException($e);
            }
        }
        $status = $paymentMethod ? 'success' : 'error';
        $message = $paymentMethod ? 'Payment method is created successfully' : 'Payment method could not be created';
        return redirect()->route('payment-methods.index')->with($status, $message);
    }

    public function edit(PaymentMethod $paymentMethod)
    {
        $breadcrumbs = Breadcrumbs::generate('editPaymentMethod', $paymentMethod);
        $responseData = [
            'paymentMethod' => $paymentMethod,
            'breadcrumbs' => $breadcrumbs,
            'pageTitle' => 'Edit Payment Method'
        ];

        return Inertia::render('PaymentMethod/Create', $responseData);
    }

    public function update(UpdatePaymentMethodRequest $request, PaymentMethod $paymentMethod)
    {
        $validatedData = $request->validated();
        if(isset($validatedData['password'])) {
            $validatedData['password'] = Hash::make($validatedData['password']);
        }
        $isUpdated = $this->paymentMethodService->update($paymentMethod, $validatedData);
        if($isUpdated){
            try{
                $this->paymentMethodService->syncPaymentMethodAcrossCompanies($paymentMethod);
            }catch(Exception $e){
                HelperService::captureException($e);
            }
        }
        $status = $isUpdated ? 'success' : 'error';
        $message = $isUpdated ?  'Payment method is updated successfully' : 'Payment method could not be updated';
        return redirect()->route('payment-methods.index')->with($status, $message);
    }

    public function destroy(PaymentMethod $paymentMethod)
    {
        $paymentMethod->deleted_by = auth()->id();
        $paymentMethod->save();
        $isDeleted = $this->paymentMethodService->delete($paymentMethod->id);
        if($isDeleted){
            try{
                $this->paymentMethodService->syncPaymentMethodDeleteAcrossCompanies($paymentMethod);
            }catch(Exception $e){
                HelperService::captureException($e);
            }
        }
        $status = $isDeleted ? 'success' : 'error';
        $message = $isDeleted ?  'Payment method is deleted successfully' : 'Payment method could not be deleted';
        return redirect()->route('payment-methods.index')->with($status, $message);
    }

    public function changeStatus(Request $request, PaymentMethod $paymentMethod)
    {
        $paymentMethod = $this->paymentMethodService->changeStatus($paymentMethod, $request->is_active);
        if($paymentMethod){
            try{
                $this->paymentMethodService->syncPaymentMethodAcrossCompanies($paymentMethod);
            }catch(Exception $e){
                HelperService::captureException($e);
            }
        }
        $status =  $paymentMethod ? 'success' : 'error';
        $message = $paymentMethod ? ($paymentMethod->is_active ? 'Payment method is activated' : 'Payment method is deactivated') : 'Payment method could not be created';
        return redirect()->back()->with($status, $message);
    }
}
