<?php

namespace App\Services\Item;

use App\Models\Item\Item;
use App\Services\APIService\Muhuri\MuhuriService;
use App\Services\BaseModelService;
use App\Services\Company\CompanyService;
use Illuminate\Support\Facades\Cache;


class ItemService extends BaseModelService
{
    private ItemUnitService $itemUnitService;
    private MuhuriService $muhuriService;
    private CompanyService $companyService;

    public function __construct(ItemUnitService $itemUnitService, MuhuriService $muhuriService, CompanyService $companyService)
    {
        $this->itemUnitService = $itemUnitService;
        $this->muhuriService = $muhuriService;
        $this->companyService = $companyService;
    }

    public function model(): string
    {
        return Item::class;
    }

    public function all($filters=[])
    {
        $items = $this->model()::with([
            'itemUnits',
            'children'
        ])->where('parent_id', null)
            ->orderBy('type')->orderBy('display_order')->get();


        return $items;
    }

    public function find($id)
    {
        $cacheKey = "item-{$id}";
        $cacheTag = "item";
        if (Cache::tags($cacheTag)->has($cacheKey)) {
            return Cache::tags($cacheTag)->get($cacheKey);
        }

        $item = $this->model()::with([
            'itemUnits',
            'children'
        ])->find($id);

        Cache::tags($cacheTag)->put($cacheKey, $item, 60 * 60 * 24);
        return $item;
    }


    public function getItems($type = null, $isActive = null)
    {
        $cacheKey = "items-{$type}-{$isActive}";
        $cacheTag = "item";
        if (Cache::tags($cacheTag)->has($cacheKey)) {
            return Cache::tags($cacheTag)->get($cacheKey);
        }

        $query = $this->model()::select('id', 'name', 'type', 'category_id', 'slug', 'is_active')
            ->when($type, function ($query) use ($type) {
                return $query->where('type', $type);
            })
            ->where('parent_id', null)
            ->with([
                'itemUnits' => function ($itemUnitQuery) {
                    $itemUnitQuery->select('id', 'item_id', 'name', 'value', 'display_name', 'form_display_name');
                },
                'children' => function ($childrenQuery) {
                    $childrenQuery = $childrenQuery->select('id', 'name', 'type', 'category_id', 'slug', 'parent_id', 'is_active')
                        ->with([
                            'itemUnits' => function ($itemUnitQuery) {
                                $itemUnitQuery->select(
                                    'id',
                                    'item_id',
                                    'name',
                                    'value',
                                    'display_name',
                                    'form_display_name'
                                );
                            }
                        ])->orderBy('display_order');
                }

            ]);
        if ($isActive) {
            $query->where('is_active', $isActive);
        }

        $items = $query->orderBy('type')->orderBy('display_order')->get();
        Cache::tags($cacheTag)->put($cacheKey, $items);
        return $items;
    }

    public function getItemCountByType($type, $isActive = true)
    {
        return $this->model()::where('type', $type)->where('is_active', $isActive)->count();
    }

    public function getByIdOrDefault($id, $defaultSlug = 'expense-others')
    {
        return $id ? Item::find($id) : Item::where('slug', $defaultSlug)->first();
    }

    public function itemDetails($parentItems)
    {
        $items = [];

        if(empty($parentItems)){
            return $items;
        }

        foreach ($parentItems as $item) {
            $item->load('companyCategory');
            $items[] = $item;
            if (!empty($item->children)) {
                foreach ($item->children as $child) {
                    $child->load('companyCategory');
                    $items[] = $child;
                }
            }
        }
        return $items;
    }

    public function changeStatus(Item $item, $isActive)
    {
        $isActive = ($isActive == true) ? false : true;
        $item->is_active = $isActive;
        $item->save();
        return $item;
    }

    public function getParentItems($type)
    {
        return $this->model()::where('parent_id',null)->where('type', $type)->get();
    }

    public function syncItems($company)
    {
        $items = $this->model()::where(['category_id' => $company->category_id, 'is_active' => true])->orWhereNull('category_id')->get();
        return $this->muhuriService->syncItems($items, $company);
    }

    public function syncItemAcrossCompanies(Item $item)
    {
        $companies = $this->companyService->getActiveCompaniesByCategoryId($item['category_id']);
        foreach ($companies as $company) {
            $this->muhuriService->syncItems($item, $company);
        }
    }
}
