<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Configuration extends Model
{
    use HasFactory, LogsActivity;


    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'option_name',
        'option_value'
    ];

    /**
     * Get corresponding country of an employee
     */
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['*']);
    }

    /**
     * Changed the activity description of events
     */
    public function getDescriptionForEvent(string $eventName): string
    {
        if ($eventName === 'updated') {
            return "Updated the configuration - $this->name";
        }

        // Default description if event is not handled
        return "Configuration {$eventName}.";
    }
}
