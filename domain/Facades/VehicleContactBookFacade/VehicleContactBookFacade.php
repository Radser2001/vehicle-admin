<?php

namespace domain\Facades\VehicleContactBookFacade;

use domain\Services\VehicleContactBookService\VehicleContactBookService;
use Illuminate\Support\Facades\Facade;

/**
 * Customer Facade
 * php version 8
 *
 * @category Facade
 * @author   CyberElysium <contact@cyberelysium.com>
 * @license  https://cyberelysium.com Config
 * @link     https://cyberelysium.com
 * */
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
