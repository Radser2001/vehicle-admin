<?php

namespace domain\Services\ImageService;

use App\Models\Image;
use Illuminate\Support\Facades\Storage;


class ImageService
{
    protected $image;

    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        $this->image = new Image();
    }

    /**
     * All
     * get all image data
     *
     * @param  int $vehicleId
     * @return Image
     */
    public function all(int $vehicleId)
    {
        return $this->image->where('vehicle_id', $vehicleId)->get();
    }


    /**
     * Store
     * store image data
     *
     * @param  mixed $image
     * @param  int $vehicleId
     * @return void
     */
    public function store($image, $vehicleId)
    {
        if (isset($image)) {
            $filePath = Storage::disk('do')->put(config('filesystems.disks.do.folder'), $image, 'public');
            $data['name'] = config('filesystems.disks.do.public_url') . '/' . $filePath;
            $data['vehicle_id'] = $vehicleId;

            return $this->image->create($data);
        }

        return null;
    }

    /**
     * Delete
     * delete image data
     *
     * @param  mixed $image
     * @return void
     */
    public function delete($imageId)
    {
        $image = $this->image::find($imageId);
        if (isset($image)) {
            $filePath = str_replace(config('filesystems.disks.do.public_url') . '/', '', $image->name);
            Storage::disk('do')->delete($filePath);

            $image->delete();
        }
    }
}
