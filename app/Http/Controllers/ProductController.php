<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Services\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    protected $productService;

    public function __construct(ProductService $product)
    {
        $this->productService = $product;
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request)
    {
        return $this->productService->index();
    }

    /**
     * @param ProductRequest $request
     * @return mixed
     */
    public function create(ProductRequest $request)
    {
        return $this->productService->create($request->all());
    }

    /**
     * @param ProductRequest $request
     * @return mixed
     */
    public function update(ProductRequest $request)
    {
        return $this->productService->update($request->all());
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function delete(Request $request)
    {
        return $this->productService->delete($request->id);
    }
}
