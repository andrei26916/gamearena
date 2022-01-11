<?php

namespace App\Jobs;

use App\Models\Product;
use App\Services\MailService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProductNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $mailService;
    protected $product;
    protected $type;

    /**
     * Create a new job instance.
     *
     * @param Product $product
     * @param string $type
     */
    public function __construct(Product $product, $type = 'created')
    {
        $this->product = $product;
        $this->type = $type;
        $this->mailService = new MailService();
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $type = $this->type . ' product';
        $message = 'product ' . $this->type . $this->product->title;
        $this->mailService->notification($type, $message);
    }
}
