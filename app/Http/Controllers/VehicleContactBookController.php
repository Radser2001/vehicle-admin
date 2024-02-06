<?php

namespace App\Http\Controllers;


use App\Http\Resources\DataResource;
use Spatie\QueryBuilder\QueryBuilder;
use App\Filters\FuzzyFilter;
use Spatie\QueryBuilder\AllowedFilter;
use App\Http\Controllers\ParentController;
use App\Http\Requests\Vehicle\UpdateContactBookRequest;
use App\Models\VehicleContactBook;
use domain\Facades\VehicleContactBookFacade\VehicleContactBookFacade;

class VehicleContactBookController extends ParentController
{
    /**
     * update
     *
     * @param  UpdateContactBookRequest $request
     * @param  int $vehicleId
     * @return void
     */
    public function update(UpdateContactBookRequest $request, int $vehicleId)
    {


        $request['vehicle_id'] = $vehicleId;
        VehicleContactBookFacade::store($request->all());
    }

    /**
     * get
     *
     * @param  int $vehicleId
     * @return void
     */
    public function all(int $vehicleId)
    {
        $query = VehicleContactBook::query()->where('vehicle_id', $vehicleId)->orderBy('id', 'desc');
        $payload = QueryBuilder::for($query)
            ->allowedSorts(['id', 'name'])
            ->allowedFilters(AllowedFilter::custom('search', new FuzzyFilter('name', 'designation', 'email', 'mobile_no', 'land_no')))
            ->paginate(request('per_page', config('basic.pagination_per_page')));
        return DataResource::collection($payload);
    }

    /**
     * delete
     *
     * @param  int $id
     * @return void
     */
    public function delete(int $id)
    {


        return  VehicleContactBookFacade::delete($id);
    }
}
