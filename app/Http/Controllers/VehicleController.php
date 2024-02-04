<?php

namespace App\Http\Controllers;

use App\Http\Requests\Vehicle\CreateVehicleRequest;
use App\Http\Requests\Vehicle\UpdateVehicleRequest;
use App\Http\Resources\DataResource;
use App\Models\Vehicle;
use domain\Facades\VehicleFacade\VehicleFacade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class VehicleController extends Controller
{
    public function index()
    {
        return Inertia::render('Vehicle/index');
    }


    /**
     * store
     *
     * @param  CreateVehicleRequest $request
     * @return void
     */
    public function store(CreateVehicleRequest $request)
    {

        if (Auth::user()) {
            return VehicleFacade::store($request->all());
        } else {
            $response['alert-danger'] = 'You do not have permission to create vendors.';
            return redirect()->route('vehicles.index')->with($response);
        }
    }


    /**
     * all
     *
     * @return void
     */
    public function all()
    {
        $query = Vehicle::orderBy('id', 'desc');
        if (request('search_vehicle_make')) {
            $make = request('search_vehicle_make');
            $query->where('make', $make);
        }
        if (request('search_vehicle_model')) {
            $model = request('search_vehicle_model');
            $query->where('model', 'like', "%{$model}%");
        }
        if (request('search_vehicle_color')) {
            $color = request('search_vehicle_color');
            $query->where('color', $color);
        }

        $payload = QueryBuilder::for($query)
            ->allowedSorts(['code'])
            ->allowedFilters(
                AllowedFilter::callback('search', function ($query, $value) {
                    $query->whereHas('make', function (Builder $query) use ($value) {
                        $query->where('name', 'like', "%{$value}%");
                    });
                    $query->orWhereHas('model', function (Builder $query) use ($value) {
                        $query->where('name', 'like', "%{$value}%");
                    });
                    $query->orWhere('id', 'like', "%{$value}%");
                    $query->orWhere('color', 'like', "%{$value}%");
                })
            )
            ->paginate(request('per_page', config('basic.pagination_per_page')));
        return DataResource::collection($payload);
    }
    public function get(int $id)
    {
        $payload = VehicleFacade::get($id);
        return new DataResource($payload);
    }

    /**
     * edit
     *
     * @param  int $id
     *
     *Show Edit Vehicle
     */
    public function edit(int $id)
    {
        if (Auth::user()) {
            $response['vehicle'] = VehicleFacade::get($id);
            // Log::info('Response:', $response);
            return Inertia::render('Vehicle/edit', $response);
        } else {
            $response['alert-danger'] = 'You do not have permission to edit Vehicle.';
            return redirect()->route('vehicles.index')->with($response);
        }
    }


    /**
     * basicUpdate
     *
     * @param  UpdateVehicleRequest  $request
     * @param  int $id
     * Update vehicle
     */
    public function update(UpdateVehicleRequest  $request, int $id)
    {
        return VehicleFacade::update($request->all(), $id);
    }

    /**
     * delete
     *
     * @param  int $id
     * Delete vehicle
     */
    public function delete(int $id)
    {
        if (Auth::user()) {
            return VehicleFacade::delete($id);
        } else {
            $response['alert-danger'] = 'You do not have permission to delete vehicle.';
            return redirect()->route('vendors.index')->with($response);
        }
    }

    /**
     * deleteSelectedItems
     *
     * @param  int $id
     * Delete Select vehicle
     */
    public function deleteSelectedItems(Request $request)
    {
        if (Auth::user()) {
            return VehicleFacade::deleteSelected($request);
        } else {
            $response['alert-danger'] = 'You do not have permission to delete vehicle.';
            return redirect()->route('vendors.index')->with($response);
        }
    }

    /**
     * inactiveSelectedItems
     *
     * @param  $request
     * Inactive vehicle status
     */
    public function inactiveSelectedItems(Request $request)
    {

        if (Auth::user()) {
            return VehicleFacade::inactive($request);
        } else {
            $response['alert-danger'] = 'You do not have permission to inactive vehicle.';
            return redirect()->route('vendors.index')->with($response);
        }
    }
    /**
     * activeSelectedItems
     *
     * @param  $request
     * Active vehicle status
     */
    public function activeSelectedItems(Request $request)
    {

        if (Auth::user()) {
            return VehicleFacade::active($request);
        } else {
            $response['alert-danger'] = 'You do not have permission to active vehicle.';
            return redirect()->route('vendors.index')->with($response);
        }
    }
}
