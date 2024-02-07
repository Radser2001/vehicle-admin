<?php

namespace domain\Services\VehicleModelService;

use App\Models\VehicleModel;
use Illuminate\Support\Str;

class VehicleModelService
{
    protected $model;
    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        $this->model = new VehicleModel();
    }

    /**
     * All
     * retrieve all the data from model model
     *
     * @return void
     */
    public function all()
    {
        return $this->model->all();
    }

    /**
     * count
     * count the number of Vehicle models
     *
     * @return void
     */

    public function count()
    {
        return $this->model->count();
    }

    /**
     * Store
     * store data in database
     *
     * @param  array $data
     * @return void
     */
    public function store(array $data)
    {
        $data['code'] = Str::slug($data['name'], '-');
        return $this->model->create($data);
    }

    /**
     * Get
     * retrieve relevant data using model_id
     *
     * @param  int  $model_id
     * @return void
     */
    public function get(int $model_id)
    {
        return $this->model->find($model_id);
    }

    /**
     * Update
     * update existing data using model_id
     *
     * @param  array $data
     * @param  int   $model_id
     * @return void
     */
    public function update(array $data, int $model_id)
    {
        $model = $this->model->find($model_id);
        $model['code'] = Str::slug($model['name']);
        return $model->update($this->edit($model, $data));
    }

    /**
     * Edit
     * merge data which retrieved from update function as an array
     *
     * @param  model $model
     * @param  array $data
     * @return void
     */
    protected function edit(VehicleModel $model, array $data)
    {
        return array_merge($model->toArray(), $data);
    }

    /**
     * Delete
     * delete specific data using model_id
     *
     * @param  int   $model_id
     * @return void
     */
    public function delete(int $model_id)
    {
        return $this->model->find($model_id)->delete();
    }

    /**
     * ChangeStatus
     * change status of the relevant data row using model_id
     *
     * @param  int  $model_id
     * @return void
     */
    public function deleteSelected($data)
    {
        $ids = $data->input('ids');
        VehicleModel::whereIn('id', $ids)->delete();

        return response()->json([
            'success' => true,
        ]);
    }

    public function inactive($data)
    {
        $ids = $data->input('ids');

        $models = VehicleModel::whereIn('id', $ids)->get();

        foreach ($models as $model) {
            $model->status = 0;
            $model->update();
        }

        return response()->json([
            'success' => true,
        ]);
    }
    public function active($data)
    {
        $ids = $data->input('ids');

        $models = VehicleModel::whereIn('id', $ids)->get();

        foreach ($models as $model) {
            $model->status = 1;
            $model->update();
        }

        return response()->json([
            'success' => true,
        ]);
    }
}
