<?php
namespace App\Repositories;

use App\Models\Product;
use App\Models\Categorie;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;

class ProductAPIRepository
{
    public function importProduct(array $apiProduct): Product
    {
        $this->validate($apiProduct);
        $processedData = $this->processData($apiProduct);
        return $this->saveProduct($processedData);
    }

    private function validate(array $data): void
    {
        $validator = Validator::make($data, [
            'title' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'required|string',
            'category' => 'required|string|max:255',
            'image' => 'nullable|url|max:2048',
        ]);
        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }

    private function processData(array $apiProduct): array
    {
        return [
            'name' => $this->cleanName($apiProduct['title']),
            'price' => $this->convertPrice($apiProduct['price']),
            'description' => strip_tags($apiProduct['description']),
            'category_id' => $this->getOrCreateCategory($apiProduct['category']),
            'image_url' => $this->validateImageUrl($apiProduct['image'] ?? null),
            'deleted' => 0 
        ];
    }

    private function cleanName(string $name): string
    {
        return trim(preg_replace('/\s+/', ' ', $name));
    }

    private function convertPrice($price): float
    {
        return round(floatval($price), 2);
    }

    private function getOrCreateCategory(string $categoryName): int
    {
        return Categorie::firstOrCreate(
            ['name' => ucwords(strtolower(trim($categoryName)))]
        )->id;
    }

    private function validateImageUrl(?string $url): ?string
    {
        return filter_var($url, FILTER_VALIDATE_URL) ? $url : null;
    }

    private function saveProduct(array $data): Product
    {
        return Product::updateOrCreate(
            [
                'name' => $data['name'],
                'category_id' => $data['category_id']
            ],
            $data
        );
    }
}