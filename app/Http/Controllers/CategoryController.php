<?php

namespace App\Http\Controllers;

use App\Filters\FuzzyFilter;
use App\Http\Requests\VehicleCategory\CreateVehicleCategoryRequest;
use App\Http\Requests\VehicleCategory\UpdateVehicleCategoryRequest;
use App\Http\Resources\DataResource;
use App\Models\Category;
use domain\Facades\VehicleCategoryFacade\VehicleCategoryFacade;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class CategoryController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        return Inertia::render('Settings/Category/All');
    }

    /**
     * all
     *
     * @return void
     */
    public function all()
    {
        $query = Category::orderBy('id', 'desc');
        $payload = QueryBuilder::for($query)
            ->allowedSorts(['id', 'name'])
            ->allowedFilters(AllowedFilter::custom('search', new FuzzyFilter('name', 'code')))
            ->paginate(request('per_page', config('basic.pagination_per_page')));
        return DataResource::collection($payload);
    }



    /**
     * count
     *
     * @return void
     */
    public function count()
    {
        return VehicleCategoryFacade::count();
    }

    /**
     * store
     *
     * @param  CreateVehicleCategoryRequest $request
     * @return void
     */
    public function store(CreateVehicleCategoryRequest $request)
    {
        return VehicleCategoryFacade::store($request->all());
    }

    /**
     * delete
     *
     * @param  int $categoryId
     * @return void
     */
    public function delete(int $categoryId)
    {
        return VehicleCategoryFacade::delete($categoryId);
    }

    /**
     * update
     *
     * @param  UpdateVehicleCategoryRequest $request
     * @param  int $categoryId
     * @return void
     */
    public function update(UpdateVehicleCategoryRequest $request, int $categoryId)
    {
        return VehicleCategoryFacade::update($request->all(), $categoryId);
    }

    /**
     * get
     *
     * @param  int $categoryId
     * @return void
     */
    public function get(int $categoryId)
    {
        $payload = VehicleCategoryFacade::get($categoryId);
        return new DataResource($payload);
    }
    public function deleteSelectedItems(Request $request)
    {
        return VehicleCategoryFacade::deleteSelected($request);
    }

    public function inactiveSelectedItems(Request $request)
    {
        return VehicleCategoryFacade::inactive($request);
    }
    public function activeSelectedItems(Request $request)
    {

        return VehicleCategoryFacade::active($request);
    }
}
