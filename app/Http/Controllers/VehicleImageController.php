<?php

namespace App\Http\Controllers;

use domain\Facades\ImageFacade\ImageFacade;
use Illuminate\Http\Request;

class VehicleImageController extends Controller
{

    public function all()
    {
        return ImageFacade::all();
    }

    public function update(Request $request)
    {
        $image = $request->file('image');
        $vehicleId = $request->route('vehicle_id');
        $image = ImageFacade::store($image, $vehicleId);
    }

    public function delete(int $imageId)
    {
        $image = ImageFacade::find($imageId);
        ImageFacade::delete($image);
    }
}
