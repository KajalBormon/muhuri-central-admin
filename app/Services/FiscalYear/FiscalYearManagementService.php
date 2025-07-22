<?php

namespace App\Services\FiscalYear;

class FiscalYearManagementService
{
    public function closeFiscalYear($fiscalYear)
    {
       $fiscalYear->update(['status' => 'end']);
       return $fiscalYear;
    }

    public function startFiscalYear($fiscalYear)
    {
        $fiscalYear->update(['status' => 'running']);
        return $fiscalYear;
    }
}
