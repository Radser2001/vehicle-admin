<?php

namespace domain\Facades\MakeFacade;

use domain\Services\MakeService\MakeService;
use Illuminate\Support\Facades\Facade;

class MakeFacade extends Facade
{
    /**
     * getFacadeAccessor
     *
     * @return void
     */
    protected static function getFacadeAccessor()
    {
        return MakeService::class;
    }
}
