<?php

namespace App\Services;
use App\Models\PaymentMethod;
use App\Services\APIService\Muhuri\MuhuriService;
use App\Services\BaseModelService;
use App\Services\Company\CompanyService;

class PaymentMethodService extends BaseModelService
{
    protected MuhuriService $muhuriService;
    protected CompanyService $companyService;

    public function __construct(MuhuriService $muhuriService, CompanyService $companyService)
    {
        $this->muhuriService = $muhuriService;
        $this->companyService = $companyService;
    }

    public function model(): string
    {
        return PaymentMethod::class;
    }

    public function getPaymentMethods()
    {
        return $this->model()::all();
    }

    public function getActivePaymentMethods($isActive = true)
    {
        return $this->model()::where('is_active', $isActive)->get();
    }

    public function changeStatus(PaymentMethod $paymentMethod, $isActive)
    {
        $isActive = ($isActive == true) ? false : true;
        $paymentMethod->is_active = $isActive;
        $paymentMethod->save();
        return $paymentMethod;
    }

    public function syncPaymentMethods($company)
    {
        $paymentMethods = $this->getActivePaymentMethods();
        return $this->muhuriService->syncPaymentMethods($paymentMethods, $company);
    }

    public function syncPaymentMethodAcrossCompanies(PaymentMethod $paymentMethod)
    {
        $companies = $this->companyService->getCompanies();
        foreach ($companies as $company) {
            $this->muhuriService->syncPaymentMethods($paymentMethod, $company);
        }
    }

    public function syncPaymentMethodDeleteAcrossCompanies(PaymentMethod $paymentMethod)
    {
        $companies = $this->companyService->getCompanies();
        foreach ($companies as $company) {
            $this->muhuriService->syncPaymentMethodDelete($paymentMethod, $company);
        }
    }
}
