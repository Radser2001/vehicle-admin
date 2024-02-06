<?php

namespace domain\Facades\VehicleContactBookFacade;

use domain\Services\VehicleContactBookService\VehicleContactBookService;
use Illuminate\Support\Facades\Facade;


class VehicleContactBookFacade extends Facade
{
    /**
     * getFacadeAccessor
     *
     * @return void
     */
    protected static function getFacadeAccessor()
    {
        return VehicleContactBookService::class;
    }
}
