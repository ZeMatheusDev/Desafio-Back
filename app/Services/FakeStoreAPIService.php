<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FakeStoreAPIService
{
    protected string $baseUrl = 'https://fakestoreapi.com/';

    protected $options;

    public function __construct()
    {
        $this->options = [
            'verify' => storage_path('certs/cacert.pem')
        ];
    }

    public function getProducts($productId = null)
    {
        try {
            $endpoint = $productId ? "products/{$productId}" : "products";

            $response = Http::withOptions($this->options)->timeout(15)
                ->retry(3, 100)
                ->get($this->baseUrl . $endpoint);

            if (!$response->successful()) {
                Log::error('FakeStore API Error: ' . $response->body());
                return null;
            }

            return $response->json();

        } catch (\Exception $e) {
            Log::error('FakeStore API Exception: ' . $e->getMessage());
            return null;
        }
    }

    public function getCategories()
    {
        try {
            $response = Http::timeout(15)
                ->get($this->baseUrl . 'products/categories');

            return $response->successful() ? $response->json() : null;

        } catch (\Exception $e) {
            Log::error('FakeStore Categories Error: ' . $e->getMessage());
            return null;
        }
    }
}