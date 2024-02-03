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
}
