<?php

namespace App\Models\Location;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Union extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $table = 'location_unions';

    public function upazila()
    {
        return $this->belongsTo(Upazila::class);
    }
}
