<?php

namespace App\Models\Item;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ItemUnit extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'item_id',
        'name',
        'value',
        'display_name',
        'form_display_name'
    ];

    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }
}
