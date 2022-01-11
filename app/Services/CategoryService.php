<?php


namespace App\Services;

use App\Models\Category;

class CategoryService
{

    /**
     * @param array $data
     * @return mixed
     */
    public function create(array $data)
    {
        return Category::create($data);
    }

    /**
     * @param $data
     * @return mixed
     */
    public function update(array $data)
    {
        return Category::where('eId', $data['eId'])->update($data);
    }

}
