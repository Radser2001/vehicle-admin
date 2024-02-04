<?php

namespace App\Http\Controllers;

use App\Http\Requests\Vehicle\CreateVehicleRequest;
use domain\Facades\VehicleFacade\VehicleFacade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class VehicleController extends Controller
{
    public function index()
    {
        return Inertia::render('Vehicles/index');
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
        $response['vehicles'] = VehicleFacade::all();
        return $response;
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
            return Inertia::render('Vehicles/edit', $response);
        } else {
            $response['alert-danger'] = 'You do not have permission to edit Vehicle.';
            return redirect()->route('vehicles.index')->with($response);
        }
    }
}
