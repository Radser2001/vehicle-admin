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

class VehicleBankAccountController extends ParentController
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
            ->allowedSorts(['id', 'bank_name'])
            ->allowedFilters(AllowedFilter::custom('search', new FuzzyFilter('bank_name', 'bank_code', 'branch_name', 'branch_code', 'swift_code', 'account_no')))
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
