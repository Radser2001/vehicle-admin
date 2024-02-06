<?php

namespace domain\Services\MakeService;

use App\Models\Make;

class MakeService
{
    protected $make;
    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        $this->make = new Make();
    }

    /**
     * All
     * retrieve all the data from make model
     *
     * @return void
     */
    public function all()
    {
        return $this->make->all();
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
        return $this->make->create($data);
    }

    /**
     * Get
     * retrieve relevant data using make_id
     *
     * @param  int  $make_id
     * @return void
     */
    public function get(int $make_id)
    {
        return $this->make->find($make_id);
    }

    /**
     * Update
     * update existing data using make_id
     *
     * @param  array $data
     * @param  int   $make_id
     * @return void
     */
    public function update(array $data, int $make_id)
    {
        $make = $this->make->find($make_id);
        return $make->update($this->edit($make, $data));
    }

    /**
     * Edit
     * merge data which retrieved from update function as an array
     *
     * @param  make $make
     * @param  array $data
     * @return void
     */
    protected function edit(Make $make, array $data)
    {
        return array_merge($make->toArray(), $data);
    }

    /**
     * Delete
     * delete specific data using make_id
     *
     * @param  int   $make_id
     * @return void
     */
    public function delete(int $make_id)
    {
        return $this->make->find($make_id)->delete();
    }

    /**
     * ChangeStatus
     * change status of the relevant data row using make_id
     *
     * @param  int  $make_id
     * @return void
     */
    public function deleteSelected($data)
    {
        $ids = $data->input('ids');
        Make::whereIn('id', $ids)->delete();

        return response()->json([
            'success' => true,
        ]);
    }

    public function inactive($data)
    {
        $ids = $data->input('ids');

        $makes = Make::whereIn('id', $ids)->get();

        foreach ($makes as $make) {
            $make->status = 0;
            $make->update();
        }

        return response()->json([
            'success' => true,
        ]);
    }
    public function active($data)
    {
        $ids = $data->input('ids');

        $makes = Make::whereIn('id', $ids)->get();

        foreach ($makes as $make) {
            $make->status = 1;
            $make->update();
        }

        return response()->json([
            'success' => true,
        ]);
    }
}
