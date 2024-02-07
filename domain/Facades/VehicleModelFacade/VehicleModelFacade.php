<?php

namespace domain\Facades\VehicleModelFacade;

use domain\Services\VehicleModelService\VehicleModelService;
use Illuminate\Support\Facades\Facade;

class VehicleModelFacade extends Facade
{
    /**
     * getFacadeAccessor
     *
     * @return void
     */
    protected static function getFacadeAccessor()
    {
        return VehicleModelService::class;
    }
}
