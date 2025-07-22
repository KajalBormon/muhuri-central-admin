<?php

namespace App\Http\Controllers;

use App\Http\Requests\Item\CreateItemRequest;
use App\Http\Requests\Item\CreateItemUnitRequest;
use App\Http\Requests\Item\UpdateItemRequest;
use App\Http\Requests\Item\UpdateItemUnitRequest;
use App\Models\Item\ItemUnit;
use App\Services\HelperService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Item\Item;
use App\Services\Company\CompanyCategoryService;
use App\Services\Item\ItemService;
use App\Services\Item\ItemUnitService;
use Diglactic\Breadcrumbs\Breadcrumbs;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class ItemController extends Controller implements HasMiddleware
{
    protected ItemService $itemService;
    protected CompanyCategoryService $companyCategoryService;
    protected ItemUnitService $itemUnitService;

    public function __construct(ItemService $itemService, ItemUnitService $itemUnitService, CompanyCategoryService $companyCategoryService)
    {
        $this->itemService = $itemService;
        $this->itemUnitService = $itemUnitService;
        $this->companyCategoryService = $companyCategoryService;
    }

    public static function middleware(): array
    {
        return [
            new Middleware('permission:can-view-item', only: ['index']),
            new Middleware('permission:can-create-item', only: ['store']),
            new middleware('permission:can-edit-item', only: ['changeStatus','edit','update','updateItemUnit']),
            new middleware('permission:can-create-item-unit', only: ['storeItemUnit']),
            new middleware('permission:can-edit-item-unit', only: ['updateItemUnit']),
            new middleware('permission:can-delete-item-unit', only: ['destroyItemUnit'])
        ];
    }

    public function index(Request $request)
    {
        $itemType = $request->query('itemType','sale');
        $breadcrumbs = Breadcrumbs::generate('items', $itemType);
        $itemsByType = $this->itemService->getItems($itemType);
        $items = $this->itemService->itemDetails($itemsByType);
        $categories = $this->companyCategoryService->getCompanyCategoriesWithName();
        $parentItems = $this->itemService->getParentItems($itemType);
        $totalCount = count($items);

        $responseData = [
            'breadcrumbs' => $breadcrumbs,
            'items' => $items,
            'categories' => $categories,
            'parentItems' => $parentItems,
            'itemType' => $itemType,
            'pageTitle' => ucfirst($itemType) . " ($totalCount)"
        ];
        return Inertia::render('Items/Index', $responseData);
    }

    public function store(CreateItemRequest $request)
    {
        $validatedData = $request->validated();
        $item = $this->itemService->create($validatedData);
        if($item){
            try{
                $this->itemService->syncItemAcrossCompanies($item);
            }catch(\Exception $e){
                HelperService::captureException($e);
            }
        }
        return redirect()->back();
    }

    public function edit(Item $item)
    {
        $breadcrumbs = Breadcrumbs::generate('editItem', $item->type, $item);
        $categories = $this->companyCategoryService->getCompanyCategoriesWithName();
        $parentItems = $this->itemService->getParentItems($item->type);
        $itemUnits = $this->itemUnitService->getItemUnits($item->id);
        $responseData = [
            'item' => $item,
            'categories' => $categories,
            'parentItems' => $parentItems,
            'itemUnits' => $itemUnits,
            'pageTitle' => 'Edit Item',
            'breadcrumbs' => $breadcrumbs,
        ];

        return Inertia::render('Items/Edit', $responseData);
    }

    public function update(UpdateItemRequest $request, Item $item)
    {
        $validatedData = $request->validated();
        $isUpdated = $this->itemService->update($item, $validatedData);
        if($isUpdated){
            try{
                $this->itemService->syncItemAcrossCompanies($item);
            }catch(\Exception $e){
                HelperService::captureException($e);
            }
        }
        $status = $isUpdated ? 'success' : 'error';
        $message = $isUpdated ? 'Item updated successfully' : 'Item could not be updated';
        return redirect()->back()->with($status, $message);
    }

    public function changeStatus(Item $item, Request $request): RedirectResponse
    {
        $item = $this->itemService->changeStatus($item, $request->is_active);
        if($item){
            try{
                $this->itemService->syncItemAcrossCompanies($item);
            }catch(\Exception $e){
                HelperService::captureException($e);
            }
        }
        $status =  $item ? 'success' : 'error';
        $message = $item ? ($item->is_active ? 'Item status is activated' : 'Item status is deactivated') : 'Item status could not be changed';
        return redirect()->back()->with($status, $message);
    }

    public function getItemsByType($type)
    {
        $items = $this->itemService->getItems($type, null);
        return response()->json($items);
    }

    public function storeItemUnit(CreateItemUnitRequest $request, Item $item)
    {
        $validatedData = $request->validated();
        $validatedData['item_id'] = $item->id;
        $item = $this->itemUnitService->create($validatedData);
        $itemUnit = $item->save();
        $status = $item && $itemUnit ? 'success' : 'error';
        $message = $item && $itemUnit ? 'Item Unit created Successfully' : 'Item Unit could not be created';
        return redirect()->back()->with($status, $message);
    }

    public function getItemUnits(Item $item)
    {
        $itemUnits = $this->itemUnitService->getItemUnits($item->id);
        return response()->json($itemUnits);
    }

    public function updateItemUnit(UpdateItemUnitRequest $request, ItemUnit $itemUnit)
    {
        $validatedData = $request->validated();
        $isUpdated = $this->itemUnitService->update($itemUnit, $validatedData);
        $status = $isUpdated ? 'success' : 'error';
        $message = $isUpdated ? 'Item unit updated successfully' : 'Item unit could not be updated';
        return redirect()->back()->with($status, $message);
    }

    public function destroyItemUnit(ItemUnit $itemUnit)
    {
        $isDeleted = $this->itemUnitService->delete($itemUnit->id);
        $status = $isDeleted ? 'success' : 'error';
        $message = $isDeleted ? 'Item unit deleted successfully' : 'Item unit could not be deleted';
        return redirect()->back()->with($status, $message);
    }
}
