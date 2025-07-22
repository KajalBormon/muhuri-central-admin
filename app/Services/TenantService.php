<?php

namespace App\Services;


use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class TenantService
{

    private mixed $tenantBaseUrl;
    private mixed $method;
    private mixed $url;
    private mixed $data;

    public function __construct()
    {
        $this->tenantBaseUrl = env('TENANT_API_URL');
        $this->method = null;
        $this->url = null;
        $this->data = null;
    }

    private function sendRequest(): Response
    {
        $url = $this->tenantBaseUrl . $this->url;
        if ($this->method === 'PUT') {
            return Http::put($url, $this->data);
        } else if ($this->method === 'POST') {
            return Http::post($url, $this->data);
        } else {
            return Http::get($url, $this->data);
        }
    }

    public function createTenant($company): Response
    {
        $this->data = [
            'name' => $company->name,
            'domain' => $company->domain,
            'workspace' => $company->workspace,
            'allowed_domains' => $company->allowed_domains
        ];
        $this->url = '/api/v1/tenants';
        $this->method = 'POST';
        $response = $this->sendRequest();
        return $response;
    }

    public function updateTenant($tenant): Response
    {
        $this->data = [
            'name' => $tenant->name,
            'domain' => $tenant->domain,
            'workspace' => $tenant->workspace,
            'allowed_domains' => $tenant->allowed_domains
        ];

        $this->url = '/api/v1/tenants-update/' . $tenant->workspace;
        $this->method = 'PUT';
        return $this->sendRequest();
    }

    public function createTenantDatabase($company, $validatedData): Response
    {
        $domain = $company->domain;
        $this->url = '/api/v1/tenant-databases/' . $domain;
        $this->method = 'POST';
        $this->data = $validatedData;
        return $this->sendRequest();
    }
}
