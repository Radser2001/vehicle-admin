<?php

namespace domain\Services\VehicleCategoryService;

use App\Models\Category;
use Illuminate\Support\Str;

class VehicleCategoryService
{
    protected $category;
    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        $this->category = new Category();
    }

    /**
     * All
     * retrieve all the data from category category
     *
     * @return void
     */
    public function all()
    {
        return $this->category->all();
    }


    /**
     * count
     * count the number of Vehicle models
     *
     * @return void
     */

    public function count()
    {
        return $this->category->count();
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
        return $this->category->create($data);
    }

    /**
     * Get
     * retrieve relevant data using category_id
     *
     * @param  int  $category_id
     * @return void
     */
    public function get(int $category_id)
    {
        return $this->category->find($category_id);
    }

    /**
     * Update
     * update existing data using category_id
     *
     * @param  array $data
     * @param  int   $category_id
     * @return void
     */
    public function update(array $data, int $category_id)
    {
        $category = $this->category->find($category_id);
        $category['code'] = Str::slug($category['name']);
        return $category->update($this->edit($category, $data));
    }

    /**
     * Edit
     * merge data which retrieved from update function as an array
     *
     * @param  category $category
     * @param  array $data
     * @return void
     */
    protected function edit(Category $category, array $data)
    {
        return array_merge($category->toArray(), $data);
    }

    /**
     * Delete
     * delete specific data using category_id
     *
     * @param  int   $category_id
     * @return void
     */
    public function delete(int $category_id)
    {
        return $this->category->find($category_id)->delete();
    }

    /**
     * ChangeStatus
     * change status of the relevant data row using category_id
     *
     * @param  int  $category_id
     * @return void
     */
    public function deleteSelected($data)
    {
        $ids = $data->input('ids');
        Category::whereIn('id', $ids)->delete();

        return response()->json([
            'success' => true,
        ]);
    }

    public function inactive($data)
    {
        $ids = $data->input('ids');

        $category = Category::whereIn('id', $ids)->get();

        foreach ($category as $category) {
            $category->status = 0;
            $category->update();
        }

        return response()->json([
            'success' => true,
        ]);
    }
    public function active($data)
    {
        $ids = $data->input('ids');

        $category = Category::whereIn('id', $ids)->get();

        foreach ($category as $category) {
            $category->status = 1;
            $category->update();
        }

        return response()->json([
            'success' => true,
        ]);
    }
}
