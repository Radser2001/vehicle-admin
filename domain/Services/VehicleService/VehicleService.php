<?php

namespace domain\Services\VehicleService;

use App\Models\Vehicle;

class VehicleService
{

    protected $vehicle;

    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        $this->vehicle = new Vehicle();
    }


    /**
     * All
     * retrieve all the data from Vehicle model
     *
     * @return void
     */
    public function all()
    {
        return $this->vehicle->all();
    }
    /**
     * Get
     * retrieve relevant data using vendor_id
     *      *
     * @param  mixed $vendor_id
     * @return void
     */
    public function get($vehicle_id)
    {
        return $this->vehicle->find($vehicle_id);
    }

    /**
     * Store
     * store data in database
     *
     * @param  mixed $data
     * @return void
     */
    public function store(array $data)
    {
        return $this->vehicle->create($data);
    }

    /**
     * Update
     * update existing data using vehicle_id
     *
     * @param  mixed $data
     * @param  mixed $vehicle_id
     * @return void
     */
    public function update(array $data, $vehicle_id)
    {
        $vehicle = $this->vehicle->find($vehicle_id);
        return $vehicle->update($this->edit($vehicle, $data));
    }

    /**
     * Edit
     * merge data which retrieved from update function as an array
     *
     * @param  mixed $vendor
     * @param  mixed $data
     * @return void
     */
    protected function edit(Vehicle $vehicle, $data)
    {
        return array_merge($vehicle->toArray(), $data);
    }
}
