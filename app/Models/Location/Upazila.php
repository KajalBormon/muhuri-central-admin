<?php

namespace App\Models\Location;

use App\Models\Buyer\Buyer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Upazila extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $table = 'location_upazilas';

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function unions()
    {
        return $this->hasMany(Union::class);
    }
}
