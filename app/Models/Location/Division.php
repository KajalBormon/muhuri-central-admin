<?php

namespace App\Models\Location;

use App\Models\Buyer\Buyer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Division extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $table = 'location_divisions';

    public function districts()
    {
        return $this->hasMany(District::class);
    }
}
