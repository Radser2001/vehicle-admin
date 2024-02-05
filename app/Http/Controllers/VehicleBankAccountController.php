<?php

namespace App\Http\Controllers;

use App\Http\Requests\Vehicle\UpdateBankAccountRequest;
use App\Models\VehicleBankAccount;
use domain\Facades\VehicleBankFacade\VehicleBankFacade;
use Illuminate\Http\Request;
use App\Filters\FuzzyFilter;
use App\Http\Resources\DataResource;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class VehicleBankAccountController extends Controller
{
    /**
     * update
     *
     * @param UpdateBankAccountRequest $request
     * @param  int $vehicleId
     * @return void
     */
    public function update(UpdateBankAccountRequest $request, int $vehicleId)
    {

        $request['vehicle_id'] = $vehicleId;
        VehicleBankFacade::store($request->all());
    }


    /**
     * get
     *
     * @param  int $vehicleId
     * @return void
     */
    public function all(int $vehicleId)
    {
        $query = VehicleBankAccount::query()->where('vehicle_id', $vehicleId)->orderBy('id', 'desc');
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


        return VehicleBankFacade::delete($id);
    }
}
