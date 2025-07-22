<?php

namespace App\Services\APIService\Muhuri;


use App\Services\Company\CompanyService;
use App\Services\ConfigurationService;
use App\Services\HelperService;
use Illuminate\Http\Client\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;

class MuhuriService extends MuhuriBaseService
{
    // This class is responsible for making requests to the Muhuri API

    private mixed $muhuriWebAPIUrl;
    private mixed $data;
    private mixed $url;
    private mixed $workspace;
    private mixed $method;
    private mixed $domain;
    private mixed $httpProtocol;
    private CompanyService $companyService;
    private ConfigurationService $configurationService;

    public function __construct( CompanyService $companyService, ConfigurationService $configurationService)
    {
        $this->muhuriWebAPIUrl = env('MUHURI_WEB_API_URL');
        $this->data = null;
        $this->url = null;
        $this->workspace = null;
        $this->method = null;
        $this->domain = null;
        $this->companyService = $companyService;
        $this->configurationService = $configurationService;
        $this->httpProtocol = $this->configurationService->getConfiguration('http_protocol');
    }


    public function sendRequest(): Response
    {
        $data = $this->data;
        $header = [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Origin' => $this->domain,
            'X-Api-Key' => env('MUHURI_WEB_API_KEY'),
        ];

        $url = $this->muhuriWebAPIUrl . $this->url;

        if ($this->method === 'POST') {
            $response = Http::withHeaders($header)->post($url, $data);
        } else if($this->method === 'GET') {
            $response = Http::withHeaders($header)->get($url, $data);
        }else if ($this->method === 'DELETE') {
            $response = Http::withHeaders($header)->delete($url, $data);
        } else {
            throw new \Exception('Unsupported HTTP method: ' . $this->method);
        }
        return $response;
    }

    public function syncSubscriptionPlansForCompanies($data): JsonResponse
    {
        $companies = $this->companyService->all();
        foreach ($companies as $company) {
            $this->syncSubscriptionPlans($data, $company);
        }
        return response()->json([
            'success' => true,
            'message' => 'Subscription plan synced successfully',
        ]);
    }

    public function syncSubscriptionPlans($data, $company): JsonResponse
    {
        $this->data = $data;
        $this->domain = HelperService::getCompanyDomain($company, $this->httpProtocol);
        $this->workspace = $company->workspace;
        $this->url = '/api/v1/muhuri-web/sync/subscription-plans';
        $this->method = 'POST';
        $response = $this->sendRequest();
        return response()->json([
            'success' => true,
            'message' => 'Subscription plan synced successfully',
        ]);
    }

    public function syncSubscription($data, $company): JsonResponse
    {
        $this->data = $data;
        $this->domain = HelperService::getCompanyDomain($company, $this->httpProtocol);
        $this->workspace = $company->workspace;
        $this->url = '/api/v1/muhuri-web/sync/subscription';
        $this->method = 'POST';
        $response = $this->sendRequest();
        return response()->json([
            'success' => true,
            'message' => 'Subscription synced successfully',
        ]);
    }

    public function syncSubscriptionPlanFeatures($data, $company): JsonResponse
    {
        $this->data = $data;
        $this->domain = HelperService::getCompanyDomain($company, $this->httpProtocol);
        $this->workspace = $company->workspace;
        $this->url = '/api/v1/muhuri-web/sync/subscription-plan-features';
        $this->method = 'POST';
        $response = $this->sendRequest();
        return response()->json([
            'success' => true,
            'message' => 'Subscription plan feature synced successfully',
        ]);
    }

    public function syncConfigurations($data, $company): JsonResponse
    {
        $this->data = $data;
        $this->domain = HelperService::getCompanyDomain($company, $this->httpProtocol);
        $this->workspace = $company->workspace;
        $this->url = '/api/v1/muhuri-web/sync/configurations';
        $this->method = 'POST';
        $response = $this->sendRequest();
        return response()->json([
            'success' => true,
            'message' => 'Configurations synced successfully',
        ]);
    }

    public function syncItems($data, $company)
    {
        $this->data = $data;
        $this->domain = HelperService::getCompanyDomain($company, $this->httpProtocol);
        $this->workspace = $company->workspace;
        $this->url = '/api/v1/muhuri-web/sync/items';
        $this->method = 'POST';
        $response = $this->sendRequest();
        return response()->json([
            'success' => true,
            'message' => 'Items synced successfully',
        ]);
    }

    public function syncBrands($data, $company)
    {
        $this->data = $data;
        $this->domain = HelperService::getCompanyDomain($company, $this->httpProtocol);
        $this->workspace = $company->workspace;
        $this->url = '/api/v1/muhuri-web/sync/brands';
        $this->method = 'POST';
        $response = $this->sendRequest();
        return response()->json([
            'success' => true,
            'message' => 'Brands synced successfully',
        ]);
    }

   // In syncBrandDelete()
    public function syncBrandDelete($data, $company)
    {
        $this->data = $data;
        $this->domain = HelperService::getCompanyDomain($company, $this->httpProtocol);
        $this->workspace = $company->workspace;
        $this->url = '/api/v1/muhuri-web/sync/brands';
        $this->method = 'DELETE';
        $response = $this->sendRequest();
        return response()->json([
            'success' => true,
            'message' => 'Brand deleted successfully',
        ]);
    }

    public function syncFiscalYears($data, $company)
    {
        $this->data = $data;
        $this->domain = HelperService::getCompanyDomain($company, $this->httpProtocol);
        $this->workspace = $company->workspace;
        $this->url = '/api/v1/muhuri-web/sync/fiscal-years';
        $this->method = 'POST';
        $response = $this->sendRequest();
        return response()->json([
            'success' => true,
            'message' => 'Fiscal years synced successfully',
        ]);
    }

    public function addFreeSMS($data, $company)
    {
        $this->data = $data;
        $this->domain = HelperService::getCompanyDomain($company, $this->httpProtocol);
        $this->workspace = $company->workspace;
        $this->url = '/api/v1/muhuri-web/sync/sms';
        $this->method = 'POST';
        $response = $this->sendRequest();
        return response()->json([
            'success' => true,
            'message' => 'Free SMS Added successfully',
        ]);
    }

    public function syncPaymentMethods($data, $company)
    {
        $this->data = $data;
        $this->domain = HelperService::getCompanyDomain($company, $this->httpProtocol);
        $this->workspace = $company->workspace;
        $this->url = '/api/v1/muhuri-web/sync/payment-methods';
        $this->method = 'POST';
        $response = $this->sendRequest();
        return response()->json([
            'success' => true,
            'message' => 'Payment method synced successfully',
        ]);
    }

    public function syncPaymentMethodDelete($data, $company)
    {
        $this->data = $data;
        $this->domain = HelperService::getCompanyDomain($company, $this->httpProtocol);
        $this->workspace = $company->workspace;
        $this->url = '/api/v1/muhuri-web/sync/payment-methods';
        $this->method = 'DELETE';
        $response = $this->sendRequest();
        return response()->json([
            'success' => true,
            'message' => 'Payment method deleted successfully'
        ]);
    }

    public function syncJobPositions($data, $company)
    {
        $this->data = $data;
        $this->domain = HelperService::getCompanyDomain($company, $this->httpProtocol);
        $this->workspace = $company->workspace;
        $this->url = '/api/v1/muhuri-web/sync/job-positions';
        $this->method = 'POST';
        $response = $this->sendRequest();
        return response()->json([
            'success' => true,
            'message' => 'Job Position synced successfully'
        ]);
    }

    public function syncJobPositionDelete($data, $company)
    {
        $this->data = $data;
        $this->domain = HelperService::getCompanyDomain($company, $this->httpProtocol);
        $this->workspace = $company->workspace;
        $this->url = '/api/v1/muhuri-web/sync/job-positions';
        $this->method = 'DELETE';
        $response = $this->sendRequest();
        return response()->json([
            'success' => true,
            'message' => 'Job Position deleted successfully'
        ]);
    }

    public function syncTenantPermissions($data, $company)
    {
        $this->data = $data;
        $this->domain = HelperService::getCompanyDomain($company, $this->httpProtocol);
        $this->workspace = $company->workspace;
        $this->url = '/api/v1/muhuri-web/sync/tenant-permissions';
        $this->method = 'POST';
        $response = $this->sendRequest();
        return response()->json([
            'success' => true,
            'message' => 'Tenant Permission synced successfully',
        ]);
    }

    public function syncTenantPermissionDelete($data, $company)
    {
        $this->data = $data;
        $this->domain = HelperService::getCompanyDomain($company, $this->httpProtocol);
        $this->workspace = $company->workspace;
        $this->url = '/api/v1/muhuri-web/sync/tenant-permissions';
        $this->method = 'DELETE';
        $response = $this->sendRequest();
        return response()->json([
            'success' => true,
            'message' => 'Tenant Permission delete synced successfully',
        ]);
    }

    public function syncTenantRoles($tenantRoles, $company)
    {
        if ($tenantRoles instanceof \Illuminate\Support\Collection) {
            $tenantRoles = $tenantRoles->all();
        } elseif (!is_array($tenantRoles)) {
            $tenantRoles = [$tenantRoles];
        }

        $data = [];

        foreach ($tenantRoles as $tenantRole) {
            $tenantRole->load('permissions');
            $permissionIds = $tenantRole->permissions->pluck('id')->toArray();
            $data[] = [
                'id' => $tenantRole->id,
                'name' => $tenantRole->name,
                'guard_name' => 'web',
                'is_active' => $tenantRole->is_active ?? true,
                'is_deletable' => false,
                'is_editable' => false,
                'permission_ids' => $permissionIds
            ];
        }

        $this->data = $data;
        $this->domain = HelperService::getCompanyDomain($company, $this->httpProtocol);
        $this->workspace = $company->workspace;
        $this->url = '/api/v1/muhuri-web/sync/tenant-roles';
        $this->method = 'POST';
        $response = $this->sendRequest();
        return response()->json([
            'success' => true,
            'message' => 'Tenant role synced successfully',
        ]);
    }


    public function syncTenantRoleDelete($data, $company)
    {
        $this->data = $data;
        $this->domain = HelperService::getCompanyDomain($company, $this->httpProtocol);
        $this->workspace = $company->workspace;
        $this->url = '/api/v1/muhuri-web/sync/tenant-roles';
        $this->method = 'DELETE';
        $response = $this->sendRequest();
        return response()->json([
            'success' => true,
            'message' => 'Tenant role delete synced successfully',
        ]);
    }

    public function syncDepartureReasons($data, $company)
    {
        $this->data = $data;
        $this->domain = HelperService::getCompanyDomain($company, $this->httpProtocol);
        $this->workspace = $company->workspace;
        $this->url = '/api/v1/muhuri-web/sync/departure-reasons';
        $this->method = 'POST';
        $response = $this->sendRequest();
        return response()->json([
            'success' => true,
            'message' => 'Departure Reason synced successfully'
        ]);
    }

    public function syncDepartureReasonDelete($data, $company)
    {
        $this->data = $data;
        $this->domain = HelperService::getCompanyDomain($company, $this->httpProtocol);
        $this->workspace = $company->workspace;
        $this->url = '/api/v1/muhuri-web/sync/departure-reasons';
        $this->method = 'DELETE';
        $response = $this->sendRequest();
        return response()->json([
            'success' => true,
            'message' => 'Departure Reason deleted successfully'
        ]);
    }


}
