<?php

namespace App\Http\Controllers;

use domain\Facades\ImageFacade\ImageFacade;
use Illuminate\Http\Request;

class VehicleImageController extends ParentController
{

    public function all(int $vehicleId)
    {
        return ImageFacade::all($vehicleId);
    }

    /**
     * update
     *
     * @param  Request $request
     * @return void
     */
    public function update(Request $request)
    {
        $image = $request->file('image');
        $vehicleId = $request->vehicle_id;
        $createdImage = ImageFacade::store($image, $vehicleId);

        if ($createdImage) {
            return $createdImage;
        } else {
            return response()->json(['error' => `Image not created`], 500);
        }
    }

    /**
     * delete
     *
     * @param  int $imageId
     * @return void
     */
    public function delete(int $imageId)
    {

        ImageFacade::delete($imageId);
    }
}
