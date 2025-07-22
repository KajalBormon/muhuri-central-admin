<?php

namespace App\Services\APIService\Muhuri;

use App\Services\HelperService;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use App\Services\ConfigurationService;

class MuhuriTenantCreateService extends MuhuriBaseService
{
    // This class is responsible for making requests to the Muhuri API
    private mixed $muhuriWebAPIUrl;
    private mixed $data;
    private mixed $url;
    private mixed $domain;
    private mixed $method;
    private mixed $httpProtocol;
    private ConfigurationService $configurationService;

    public function __construct(ConfigurationService $configurationService)
    {
        $this->muhuriWebAPIUrl = env('MUHURI_WEB_API_URL');
        $this->data = null;
        $this->url = null;
        $this->domain = null;
        $this->method = null;
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
        } else {
            $response = Http::withHeaders($header)->get($url, $data);
        }
        return $response;
    }

    public function migrateDatabase($company): Response
    {
        $this->data = [
            'database_name' => $company->workspace,
        ];
        $this->domain = HelperService::getCompanyDomain($company, $this->httpProtocol);
        $this->url = '/api/v1/muhuri-web/tenant/migration';
        $this->method = 'POST';
        return $this->sendRequest();
    }

    public function loadInitialData($company): Response
    {
        $this->data = [
            'name' => $company->name,
            'name_bn' => $company->name_bn,
            'category' => $company->companyCategory?->slug,
            'workspace' => $company->workspace,
            'workspace_domain' => $company->domain,
            'mobile_number' => $company->mobile_number,
            'additional_mobile_number' => $company->additional_mobile_number,
            'address' => HelperService::getAddress($company)
        ];
        $this->domain = HelperService::getCompanyDomain($company, $this->httpProtocol);
        $this->url = '/api/v1/muhuri-web/tenant/run-seeders';
        $this->method = 'POST';
        return $this->sendRequest();
    }

    public function createAdminUser($company, $validatedData)
    {
        $this->data = $validatedData;
        $this->domain = HelperService::getCompanyDomain($company, $this->httpProtocol);
        $this->method = 'POST';
        $this->url = '/api/v1/muhuri-web/tenant/create-admin-user';
        return $this->sendRequest();
    }
}
