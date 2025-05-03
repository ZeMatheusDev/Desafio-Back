<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::with(['category'])
            ->where('products.deleted', 0)
            ->join('categories', 'categories.id', '=', 'products.category_id')
            ->select([
                'products.id',
                'products.name',
                'price',
                'description',
                'image_url',
                'categories.name as category_name'
            ]);
    
        if ($request->has('name') && $request->name != '') {
            $products->where('products.name', 'LIKE', '%' . $request->name . '%');
        }
    
        if ($request->has('price') && $request->price != '') {
            $products->where('price', $request->price);
        }
    
        if ($request->has('description') && $request->description != '') {
            $products->where('description', 'LIKE', '%' . $request->description . '%');
        }
    
        if ($request->has('category') && $request->category != '') {
            $products->where('categories.name', 'LIKE', '%' . $request->category . '%');
        }

        if ($request->has('has_image')) {
            if ($request->has_image === 'yes') {
                $products->whereNotNull('image_url');
            } elseif ($request->has_image === 'no') {
                $products->whereNull('image_url');
            }
        }
    
        $products = $products->get()->map(function ($product) {
            $product->image_url = str_replace('/', '-', $product->image_url);
            return $product;
        });

        return view('product.list')->with('products', $products);
    }

    public function create(){
        $categorias = Categorie::where('deleted', 0)->get();

        return view('/product/create')->with('categories', $categorias);
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'image_url' => 'nullable|image|mimes:jpeg,png,jpg,gif'
        ]);

        $imagePath = null;
        if ($request->hasFile('image_url')) {
            $file = $request->file('image_url');
            
            $fileName = 'prod_' . time() . '_' . bin2hex(random_bytes(4)) . '.' . $file->extension();
            
            $imagePath = $file->storeAs(
                'products/images',  
                $fileName,          
                'public'            
            );
        }

        Product::create([
            'name' => $validated['name'],
            'price' => $validated['price'],
            'description' => $validated['description'],
            'category_id' => $validated['category_id'],
            'image_url' => $imagePath,
            'deleted' => 0
        ]);

        return redirect()->route('product.list')->with('success', 'Produto criado com sucesso!');
    }

    public function delete(Request $request){
        Product::where('id', $request->id)->update(['deleted' => 1]);

        return redirect()->route('product.list')->with('success', 'Categoria deletada com sucesso!');
    }

    public function edit($id){
        $categorias = Categorie::where('deleted', 0)->get();

        $product = Product::where('id', $id)->first();

        return view('/product/edit', ['product' => $product, 'categories' => $categorias]);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'image_url' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
    
        $product = Product::findOrFail($request->id);
        $oldImagePath = $product->image_url;
    
        if ($request->hasFile('image_url')) {
            $file = $request->file('image_url');
            $fileName = 'prod_' . time() . '_' . bin2hex(random_bytes(4)) . '.' . $file->extension();
            $imagePath = $file->storeAs(
                'products/images',
                $fileName,
                'public'
            );
            
            $validated['image_url'] = $imagePath;
        } else {
            $validated['image_url'] = $oldImagePath;
        }
    
        $product->update($validated);
    
        return redirect()->route('product.list')->with('success', 'Produto atualizado com sucesso!');
    }
}
