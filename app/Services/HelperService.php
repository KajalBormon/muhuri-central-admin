<?php

namespace App\Services;

use Exception;
use App\Constants\Constants;

class HelperService
{
    public static function getBloodGroups()
    {
        return [
            [ 'value' => 'A+', 'text' => 'A+' ],
            [ 'value' => 'A-', 'text' => 'A-' ],
            [ 'value' => 'B+', 'text' => 'B+' ],
            [ 'value' => 'B-', 'text' => 'B-' ],
            [ 'value' => 'AB+', 'text' => 'AB+' ],
            [ 'value' => 'AB-', 'text' => 'AB-' ],
            [ 'value' => 'O+', 'text' => 'O+' ],
            [ 'value' => 'O-', 'text' => 'O-' ]
        ];
    }

    public static function getGenders()
    {
        return [
            [ 'value' => Constants::MALE, 'text' => ucfirst(Constants::MALE) ],
            [ 'value' => Constants::FEMALE, 'text' => ucfirst(Constants::FEMALE) ],
            [ 'value' => Constants::OTHERS, 'text' => ucfirst(Constants::OTHERS) ]
        ];
    }

    public static function getDateFormats()
    {
        return [
            [ 'value' => Constants::Y_M_D, 'text' => Constants::Y_M_D ],
            [ 'value' => Constants::M_D_Y, 'text' => Constants::M_D_Y ],
            [ 'value' => Constants::D_M_Y, 'text' => Constants::D_M_Y ]
        ];
    }

    public static function getMaritalStatus()
    {
        return [
            [ 'value' => Constants::SINGLE, 'text' => ucfirst(Constants::SINGLE) ],
            [ 'value' => Constants::MARRIED, 'text' => ucfirst(Constants::MARRIED) ],
            [ 'value' =>  Constants::LEGAL_COHABITANT, 'text' => ucfirst(Constants::LEGAL_COHABITANT) ],
            [ 'value' =>  Constants::WIDOWER, 'text' => ucfirst(Constants::WIDOWER) ],
            [ 'value' =>  Constants::DIVORCED, 'text' => ucfirst(Constants::DIVORCED) ]
        ];
    }

    public static function getPlanTypes()
    {
        return [
            ['value' => Constants::MONTHLY, 'text' => ucfirst(Constants::MONTHLY)],
            ['value' => Constants::YEARLY, 'text' => ucfirst(Constants::YEARLY)]
        ];
    }

    public static function getDurationUnits()
    {
        return [
            ['value' => Constants::MONTHS, 'text' => ucfirst(Constants::MONTHS)],
        ];
    }

    public static function getCompanyDomain($company, $httpProtocol)
    {
        $allowedDomains = $company->allowed_domains;
        $allowedDomainsJson = json_decode($allowedDomains, true);
        return $httpProtocol . '://' . reset($allowedDomainsJson);
    }

    static function getAddress($object)
    {
        $locationService = new LocationService();

        $addressParts = [];
        if (!empty($object->village)) {
            $addressParts[] = $object->village;
        }
        $union = $locationService->getUnion($object->union_id);
        if ($union) {
            $addressParts[] = $union->bn_name;
        }

        $upazila = $locationService->getUpazila($object->upazila_id);
        if ($upazila) {
            $addressParts[] = $upazila->bn_name;
        }

        $district = $locationService->getDistrict($object->district_id);
        if ($district) {
            $addressParts[] = $district->bn_name;
        }

        $address = implode(', ', $addressParts);

        return $address;
    }

    public static function captureException(Exception $e)
    {
        \Sentry\captureException($e);
    }

}
