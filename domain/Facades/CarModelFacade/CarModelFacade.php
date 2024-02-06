<?php

namespace domain\Facades\CarModelFacade;

use domain\Services\CarModelService\CarModelService;
use Illuminate\Support\Facades\Facade;

class CarModelFacade extends Facade
{
    /**
     * getFacadeAccessor
     *
     * @return void
     */
    protected static function getFacadeAccessor()
    {
        return CarModelService::class;
    }
}
