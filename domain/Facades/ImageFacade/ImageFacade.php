<?php

namespace domain\Facades\ImageFacade;

use domain\Services\ImageService\ImageService;
use Illuminate\Support\Facades\Facade;


class ImageFacade extends Facade
{
    /**
     * getFacadeAccessor
     *
     * @return void
     */
    protected static function getFacadeAccessor()
    {
        return ImageService::class;
    }
}
