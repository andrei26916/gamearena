<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Services\ProductService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;

class JsonProduct extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'json:product';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'created/updated product from json file';

    protected $productService;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->productService = new ProductService();
    }

    protected $rules = [
        'title' => ['required', 'string', 'min:3', 'max:12'],
        'price' => ['required', 'regex:/^\d*(\.\d{2})?$/', 'min:0', 'max:200'],
        'eId' => ['required', 'integer'],
        'categoriesEId' => ['required', 'array'],

    ];

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $path = $this->ask('name and path file (if the file is in the root, the path is not needed)');
        $result = json_decode(file_get_contents($path));

        foreach ($result as $item){
            $item = (array)$item;
            $validation = Validator::make($item, $this->rules);
            if ($validation->fails()){
                dump($item);
                $validation->errors()->toArray();
                $this->error(($validation->errors()));
                return 0;
            }

            $categories = Category::whereIn('eId', $item['categoriesEId'])->get();
            $item['categories'] = $categories->map(function ($query){
                return $query->id;
            })->toArray();

            $product = $this->productService->update($item);
            if (!$product){
                $product = $this->productService->create($item);
                $product->categories()->attach($item['categories']);
            }

            dump($item);
            $this->info('success');

        }

        return 0;
    }
}
