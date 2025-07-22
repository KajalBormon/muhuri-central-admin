<?php

namespace App\Services;

use App\Models\Configuration;
use App\Models\Country;
use Illuminate\Support\Facades\DB;

class ConfigurationService extends BaseModelService
{
    public function model(): string
    {
        return Configuration::class;
    }

    public function getCompanyPublicConfiguration()
    {
        $configurations = $this->model()::all();
        $mergedConfiguration = collect();

        // Transform each configuration item
        $configurations->each(function ($configuration) use ($mergedConfiguration) {
            if($configuration->option_name === 'country_id') {
                $country = Country::find($configuration->option_value);
                $countryName = $country ? $country->name : null;

                $mergedConfiguration->put('country_id', $configuration->option_value);
                $mergedConfiguration->put('country_name', $countryName);
            } else {
                if ($configuration->option_name === 'weekends') {
                    $configuration->option_value = json_decode($configuration->option_value, true);
                } else if ($configuration->option_name === 'is_roster') {
                    $configuration->option_value = $configuration->option_value == '1' ? 1 : 0;
                }

                $mergedConfiguration->put($configuration->option_name, $configuration->option_value);
            }
        });

        return (object) $mergedConfiguration;
    }

    public function updateConfiguration($validatedData)
    {
        $result = DB::transaction(function() use ($validatedData) {
            foreach ($validatedData as $key => $data) {
                $this->model()::updateOrCreate(
                    ['option_name' => $key],
                    ['option_value' => $data]
                );
            }
            return true;
        });
        return $result;
    }

    public function getConfiguration($optionName)
    {
        return $this->model()::where('option_name', $optionName)->value('option_value');
    }

    public function getSupportDetails()
    {
        $supportEmail = $this->getConfiguration('support_email');
        $supportTelephone = $this->getConfiguration('support_telephone');
        $responseData = [
            'supportEmail' => $supportEmail,
            'supportTelephone' => $supportTelephone
        ];
        return $responseData;
    }
}
