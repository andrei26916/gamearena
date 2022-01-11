<?php

namespace App\Console\Commands;

use App\Services\CategoryService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;

class JsonCategory extends Command
{
    protected $categoryService;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'json:category';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'created/updated category from json file';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->categoryService = new CategoryService();
    }

    protected $rules = [
        'title' => ['required', 'string', 'min:3', 'max:12'],
        'eId' => ['required', 'integer', ''],
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

            $category = $this->categoryService->update($item);

            if (!$category) {
                $this->categoryService->create($item);
            }

            dump($item);
            $this->info('success');
        }

        return 0;

    }
}
