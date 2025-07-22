<?php

namespace App\Http\Controllers;

use App\Services\SyncService;
use Exception;
use Inertia\Inertia;
use App\Constants\Constants;
use App\Services\HelperService;
use App\Services\CountryService;
use App\Services\ConfigurationService;
use Diglactic\Breadcrumbs\Breadcrumbs;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;
use App\Http\Requests\Configuration\UpdateConfigurationRequest;

class ConfigurationController extends Controller implements HasMiddleware
{
    protected ConfigurationService $configurationService;
    protected CountryService $countryService;
    protected SyncService $syncService;

    public function __construct(ConfigurationService $configurationService, CountryService $countryService, SyncService $syncService)
    {
        $this->configurationService = $configurationService;
        $this->countryService = $countryService;
        $this->syncService = $syncService;
    }

    public static function middleware(): array
    {
        return [
            new Middleware('permission:can-view-configuration', only: ['details']),
            new Middleware('permission:can-edit-configuration', only: ['basicInfo', 'updateBasicInfo', 'additionalInfo', 'updateAdditionalInfo', 'contactInfo', 'updateContactInfo', 'globalInfo', 'updateGlobalInfo', 'smsService', 'updateSmsService'])
        ];
    }

    public function details()
    {
        $configuration = $this->configurationService->getCompanyPublicConfiguration();
        $breadcrumbs = Breadcrumbs::generate('settings', $configuration);
        $responseData = [
            'configuration' => $configuration,
            'breadcrumbs' => $breadcrumbs,
            'pageTitle' => __('pageTitle.custom.configuration.details')
        ];
        return Inertia::render('Configuration/Details', $responseData);
    }

    public function basicInfo()
    {
        $configuration = $this->configurationService->getCompanyPublicConfiguration();
        $breadcrumbs = Breadcrumbs::generate('settingsBasicInfo', $configuration);
        $countries = $this->countryService->getCountries();
        $responseData = [
            'countries' => $countries,
            'configuration' => $configuration,
            'breadcrumbs' => $breadcrumbs,
            'pageTitle' => __('pageTitle.custom.configuration.basicInfo')
        ];
        return Inertia::render('Configuration/BasicInfo', $responseData);
    }

    public function updateBasicInfo(UpdateConfigurationRequest $request)
    {
        $validatedData = $request->validated();
        $isUpdated = $this->configurationService->updateConfiguration($validatedData);
        $status = $isUpdated ? Constants::SUCCESS : Constants::ERROR;
        $message = $isUpdated ? __('message.custom.configuration.update.basicInfo.success') : __('message.custom.configuration.basicInfo.error');
        return Redirect::route('configurations.details')->with($status, $message);
    }

    public function additionalInfo()
    {
        $configuration = $this->configurationService->getCompanyPublicConfiguration();
        $breadcrumbs = Breadcrumbs::generate('settingsAdditionalInfo', $configuration);
        $dateFormats = HelperService::getDateFormats();
        $responseData = [
            'dateFormats' => $dateFormats,
            'configuration' => $configuration,
            'breadcrumbs' => $breadcrumbs,
            'pageTitle' => __('pageTitle.custom.configuration.additionalInfo')
        ];
        return Inertia::render('Configuration/AdditionalInfo', $responseData);
    }

    public function updateAdditionalInfo(UpdateConfigurationRequest $request)
    {
        $validatedData = $request->validated();
        $isUpdated = $this->configurationService->updateConfiguration($validatedData);
        $status = $isUpdated ? Constants::SUCCESS : Constants::ERROR;
        $message = $isUpdated ? __('message.custom.configuration.update.additionalInfo.success'): __('message.custom.configuration.additionalInfo.error');
        return Redirect::route('configurations.details')->with($status, $message);
    }

    public function contactInfo()
    {
        $configuration = $this->configurationService->getCompanyPublicConfiguration();
        $breadcrumbs = Breadcrumbs::generate('settingsContactInfo', $configuration);
        $responseData = [
            'configuration' => $configuration,
            'breadcrumbs' => $breadcrumbs,
            'pageTitle' =>  __('pageTitle.custom.configuration.contactInfo')
        ];
        return Inertia::render('Configuration/ContactInfo', $responseData);
    }

    public function updateContactInfo(UpdateConfigurationRequest $request)
    {
        $validatedData = $request->validated();
        $isUpdated = $this->configurationService->updateConfiguration($validatedData);
        $status = $isUpdated ? Constants::SUCCESS : Constants::ERROR;
        $message = $isUpdated ? __('message.custom.configuration.update.contactInfo.success') : __('message.custom.configuration.contactInfo.error');
        return Redirect::route('configurations.details')->with($status, $message);
    }

    public function globalInfo()
    {
        $configuration = $this->configurationService->getCompanyPublicConfiguration();
        $breadcrumbs = Breadcrumbs::generate('settingsGlobalInfo', $configuration);
        $responseData = [
            'configuration' => $configuration,
            'breadcrumbs' => $breadcrumbs,
            'pageTitle' =>  __('pageTitle.custom.configuration.globalInfo')
        ];
        return Inertia::render('Configuration/GlobalInfo', $responseData);
    }

    public function updateGlobalInfo(UpdateConfigurationRequest $request)
    {
        $validatedData = $request->validated();
        $isUpdated = $this->configurationService->updateConfiguration($validatedData);
        if ($isUpdated) {
            try {
                $data = [
                    'support_email' => $validatedData['support_email'],
                    'support_telephone' => $validatedData['support_telephone']
                ];
                $this->syncService->syncConfigurationAcrossCompanies($data);
            } catch(Exception $e) {
                HelperService::captureException($e);
            }
        }
        $status = $isUpdated ? Constants::SUCCESS : Constants::ERROR;
        $message = $isUpdated ? __('message.custom.configuration.update.globalInfo.success') : __('message.custom.configuration.globalInfo.error');
        return Redirect::route('configurations.details')->with($status, $message);
    }

    public function smsService()
    {
        $configuration = $this->configurationService->getCompanyPublicConfiguration();
        $breadcrumbs = Breadcrumbs::generate('settingsSmsService', $configuration);
        $responseData = [
            'configuration' => $configuration,
            'breadcrumbs' => $breadcrumbs,
            'pageTitle' => __('pageTitle.custom.configuration.smsService'),
        ];
        return Inertia::render('Configuration/SmsService', $responseData);
    }

    public function updateSmsService(UpdateConfigurationRequest $request)
    {
        $validatedData = $request->validated();
        $isUpdated = $this->configurationService->updateConfiguration($validatedData);
        $status = $isUpdated ? Constants::SUCCESS : Constants::ERROR;
        $message = $isUpdated ? __('message.custom.configuration.update.smsService.success') : __('message.custom.configuration.SmsService.error');
        return Redirect::route('configurations.details')->with($status, $message);
    }
}
