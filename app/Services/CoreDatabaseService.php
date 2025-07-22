<?php

namespace App\Services;

use App\Models\CoreDatabase;
class CoreDatabaseService extends BaseModelService
{


    public function model(): string
    {
        return CoreDatabase::class;
    }

    public function getActiveDatabase()
    {
        return CoreDatabase::where('is_active', true)->first();
    }

}
