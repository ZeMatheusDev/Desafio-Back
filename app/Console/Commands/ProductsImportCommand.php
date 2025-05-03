<?php

namespace App\Console\Commands;

use App\Jobs\ImportProductJob;
use Illuminate\Console\Command;
use App\Services\FakeStoreAPIService;

class ProductsImportCommand extends Command
{
    protected $signature = 'products:import {--id=}';
    
    protected $description = 'Import products from FakeStore API';

    public function handle(FakeStoreAPIService $apiService)
    {
        $productId = $this->option('id');

        if ($productId) {
            $this->processSingleProduct($productId);
        } else {
            $this->processAllProducts($apiService);
        }
    }

    private function processSingleProduct($id): void
    {
        try {
            $importProductJob = new ImportProductJob($id);
            $repository = app(\App\Repositories\ProductAPIRepository::class);
            $service = app(FakeStoreAPIService::class);
            $importProductJob->handle($service, $repository);
            ImportProductJob::dispatch($id);
            $this->info("Job para importar produto ID: {$id} despachado para a fila!");
        } catch (\Exception $e) {
            $this->error("Erro ao despachar job: " . $e->getMessage());
        }
    }

    private function processAllProducts(FakeStoreAPIService $apiService): void
    {
        try {
            $products = $apiService->getProducts();
  
            if (empty($products)) {
                $this->error("Nenhum produto encontrado na API");
                return;
            }

            $this->info("Iniciando importação de " . count($products) . " produtos...");
            
            $progressBar = $this->output->createProgressBar(count($products));
            
            foreach ($products as $product) {
                try {
                    $importProductJob = new ImportProductJob($product['id']);
                    $repository = app(\App\Repositories\ProductAPIRepository::class);
                    $service = app(FakeStoreAPIService::class);
                    $importProductJob->handle($service, $repository);
                    ImportProductJob::dispatch($product['id']); 
                    $progressBar->advance();
                } catch (\Exception $e) {
                    $this->newLine();
                    $this->error("Erro no produto {$product['id']}: " . $e->getMessage());
                }
            }
            
            $progressBar->finish();
            $this->newLine(2);
            $this->info("Todos os jobs foram enfileirados com sucesso!");
            
        } catch (\Exception $e) {
            $this->error("Erro na comunicação com a API: " . $e->getMessage());
        }
    }
}