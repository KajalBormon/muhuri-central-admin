<?php

namespace App\Models\Item;

use App\Models\CompanyCategory;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;

class Item extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'name',
        'slug',
        'type',
        'category_id',
        'parent_id',
        'description',
        'display_order',
        'created_by',
        'updated_by',
    ];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }

    public function children(): HasMany
    {
        return $this->hasMany(Item::class, 'parent_id', 'id');
    }

    public function companyCategory(): BelongsTo
    {
        return $this->belongsTo(CompanyCategory::class, 'category_id');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function itemUnits(): HasMany
    {
        return $this->hasMany(ItemUnit::class);
    }

    public function isParent(): bool
    {
        return $this->parent_id === null;
    }

    public function isChild(): bool
    {
        return $this->parent_id !== null && $this->parent_id !== "";
    }

    protected static function booted(): void
    {
        static::saved(function (Item $item) {
            try {
                Cache::tags("item")->flush();
            } catch (\Exception $e) {
                // do nothing
            }
        });


        static::deleted(function (Item $item) {
            Cache::tags("item")->flush();
        });
    }
}
