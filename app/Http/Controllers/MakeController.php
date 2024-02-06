<?php

namespace App\Http\Controllers;

use App\Filters\FuzzyFilter;
use App\Http\Requests\Make\CreateMakeRequest;
use App\Http\Requests\Make\UpdateMakeRequest;
use App\Http\Resources\DataResource;
use App\Models\Make;
use domain\Facades\MakeFacade\MakeFacade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class MakeController extends ParentController
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
        $query = Make::orderBy('id', 'desc');
        $payload = QueryBuilder::for($query)
            ->allowedSorts(['id', 'name'])
            ->allowedFilters(AllowedFilter::custom('search', new FuzzyFilter('name', 'code')))
            ->paginate(request('per_page', config('basic.pagination_per_page')));
        return DataResource::collection($payload);
    }

    /**
     * store
     *
     * @param  CreateMakeRequest $request
     * @return void
     */
    public function store(CreateMakeRequest $request)
    {
        return MakeFacade::store($request->all());
    }

    /**
     * delete
     *
     * @param  int $makeId
     * @return void
     */
    public function delete(int $makeId)
    {
        return MakeFacade::delete($makeId);
    }

    /**
     * update
     *
     * @param  UpdateMakeRequest $request
     * @param  int $makeId
     * @return void
     */
    public function update(UpdateMakeRequest $request, int $makeId)
    {
        return MakeFacade::update($request->all(), $makeId);
    }

    /**
     * get
     *
     * @param  int $makeId
     * @return void
     */
    public function get(int $makeId)
    {
        $payload = MakeFacade::get($makeId);
        return new DataResource($payload);
    }
    public function deleteSelectedItems(Request $request)
    {
        return MakeFacade::deleteSelected($request);
    }

    public function inactiveSelectedItems(Request $request)
    {
        return MakeFacade::inactive($request);
    }
    public function activeSelectedItems(Request $request)
    {

        return MakeFacade::active($request);
    }
}
