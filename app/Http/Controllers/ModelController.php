<?php

namespace App\Http\Controllers;

use App\Filters\FuzzyFilter;
use App\Http\Requests\VehicleModel\CreateVehicleModelRequest;
use App\Http\Requests\VehicleModel\UpdateVehicleModelRequest;
use App\Http\Resources\DataResource;
use App\Models\VehicleModel;
use domain\Facades\VehicleModelFacade\VehicleModelFacade;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class ModelController extends ParentController
{
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        return Inertia::render('Settings/Model/All');
    }

    /**
     * all
     *
     * @return void
     */
    public function all()
    {
        $query = VehicleModel::orderBy('id', 'desc');
        $payload = QueryBuilder::for($query)
            ->allowedSorts(['id', 'name'])
            ->allowedFilters(AllowedFilter::custom('search', new FuzzyFilter('name', 'code')))
            ->paginate(request('per_page', config('basic.pagination_per_page')));
        return DataResource::collection($payload);
    }

    /**
     * store
     *
     * @param  CreateVehicleModelRequest $request
     * @return void
     */
    public function store(CreateVehicleModelRequest $request)
    {
        return VehicleModelFacade::store($request->all());
    }

    /**
     * delete
     *
     * @param  int $modelId
     * @return void
     */
    public function delete(int $modelId)
    {
        return VehicleModelFacade::delete($modelId);
    }

    /**
     * update
     *
     * @param  UpdateVehicleModelRequest $request
     * @param  int $modelId
     * @return void
     */
    public function update(UpdateVehicleModelRequest $request, int $modelId)
    {
        return VehicleModelFacade::update($request->all(), $modelId);
    }

    /**
     * get
     *
     * @param  int $modelId
     * @return void
     */
    public function get(int $modelId)
    {
        $payload = VehicleModelFacade::get($modelId);
        return new DataResource($payload);
    }
    public function deleteSelectedItems(Request $request)
    {
        return VehicleModelFacade::deleteSelected($request);
    }

    public function inactiveSelectedItems(Request $request)
    {
        return VehicleModelFacade::inactive($request);
    }
    public function activeSelectedItems(Request $request)
    {

        return VehicleModelFacade::active($request);
    }
}
