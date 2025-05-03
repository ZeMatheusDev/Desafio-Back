<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'name',
        'price',
        'description',
        'category_id',
        'image_url',
        'deleted'
    ];

    public function category()
    {
        return $this->belongsTo(Categorie::class);
    }
}
