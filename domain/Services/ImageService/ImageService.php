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
     * @return Image
     */
    public function all()
    {
        return $this->image->all();
    }

    public function store($image, $vehicleId): Image
    {
        if (isset($image)) {
            $filePath = Storage::disk('do')->put(config('filesystems.disks.do.folder'), $image, 'public');
            $data['name'] = config('filesystems.disks.do.public_url') . '/' . $filePath;
            $data['vehicle_id'] = $vehicleId;

            return $this->image->create($data);
        }
    }

    /**
     * Delete
     * delete image data
     *
     * @param  mixed $image
     * @return void
     */
    public function delete($image)
    {
        if (isset($image)) {
            $filePath = str_replace(config('filesystems.disks.do.public_url') . '/', '', $image->name);
            Storage::disk('do')->delete($filePath);

            $image->delete();
        }
    }
}
