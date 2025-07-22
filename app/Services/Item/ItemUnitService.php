<?php

namespace App\Services\Item;

use App\Models\Item\ItemUnit;
use App\Services\BaseModelService;

class ItemUnitService extends BaseModelService
{
    public function model(): string
    {
        return ItemUnit::class;
    }

    public function getItemUnits($itemId)
    {
        return $this->model()::select('id', 'name', 'value', 'display_name', 'form_display_name','item_id')->where('item_id', $itemId)->get();
    }

    public function create($validatedData)
    {
        return $this->model()::create($validatedData);
    }
}
