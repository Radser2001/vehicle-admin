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
        // dd($request->all());
        $image = $request->file('image');
        $vehicleId = $request->vehicle_id;
        $createdImage = ImageFacade::store($image, $vehicleId);

        if ($createdImage) {
            return $createdImage;
        } else {
            return response()->json(['error' => `Image not created`], 500);
        }
    }

    public function delete(int $imageId)
    {
        $image = ImageFacade::find($imageId);
        ImageFacade::delete($image);
    }
}
