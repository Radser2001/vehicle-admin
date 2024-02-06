<?php

namespace App\Http\Controllers;

use App\Filters\FuzzyFilter;
use App\Http\Requests\Make\CreateModelRequest;
use App\Http\Requests\Make\UpdateModelRequest;
use App\Http\Resources\DataResource;
use App\Models\CarModel;
use domain\Facades\CarModelFacade\CarModelFacade;
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
        return Inertia::render('Settings/Make/All');
    }

    /**
     * all
     *
     * @return void
     */
    public function all()
    {
        $query = CarModel::orderBy('id', 'desc');
        $payload = QueryBuilder::for($query)
            ->allowedSorts(['id', 'name'])
            ->allowedFilters(AllowedFilter::custom('search', new FuzzyFilter('name', 'code')))
            ->paginate(request('per_page', config('basic.pagination_per_page')));
        return DataResource::collection($payload);
    }

    /**
     * store
     *
     * @param  CreateModelRequest $request
     * @return void
     */
    public function store(CreateModelRequest $request)
    {
        return CarModelFacade::store($request->all());
    }

    /**
     * delete
     *
     * @param  int $modelId
     * @return void
     */
    public function delete(int $modelId)
    {
        return CarModelFacade::delete($modelId);
    }

    /**
     * update
     *
     * @param  UpdateModelRequest $request
     * @param  int $modelId
     * @return void
     */
    public function update(UpdateModelRequest $request, int $modelId)
    {
        return CarModelFacade::update($request->all(), $modelId);
    }

    /**
     * get
     *
     * @param  int $modelId
     * @return void
     */
    public function get(int $modelId)
    {
        $payload = CarModelFacade::get($modelId);
        return new DataResource($payload);
    }
    public function deleteSelectedItems(Request $request)
    {
        return CarModelFacade::deleteSelected($request);
    }

    public function inactiveSelectedItems(Request $request)
    {
        return CarModelFacade::inactive($request);
    }
    public function activeSelectedItems(Request $request)
    {

        return CarModelFacade::active($request);
    }
}
