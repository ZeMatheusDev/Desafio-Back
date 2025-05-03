<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Services\FakeStoreAPIService;
use App\Repositories\ProductAPIRepository;

class ImportProductJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(protected int $productId) {

    }

    public function handle(
        FakeStoreAPIService $apiService,
        ProductAPIRepository $repository
    ) {
        $productData = $apiService->getProducts($this->productId);

        if ($productData) {
            $repository->importProduct($productData);
        }
    }
}