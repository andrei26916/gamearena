<?php


namespace App\Services;


use App\Jobs\ProductNotification;
use App\Models\Product;

class ProductService
{

    /**
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function index()
    {
        return Product::with('categories')->get();
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function create(array $data)
    {
        $product = Product::create($data);
        dispatch(new ProductNotification($product));
        return $product;
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function update(array $data)
    {
        $product = Product::where('eId', $data['eId'])->update([
               'title' => $data['title'],
               'price' => $data['price'],
               'eId' => $data['eId']
        ]);
        if ($product){
            dispatch(new ProductNotification(Product::where('eId', $data['eId'])->first(), 'updated'));
        }
        return $product;
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function delete(int $id)
    {
        return Product::where('id', $id)->delete();
    }

}
