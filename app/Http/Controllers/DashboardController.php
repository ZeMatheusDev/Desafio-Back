<?php

namespace App\Http\Controllers;

use App\Jobs\ImportProductJob;
use App\Models\Product;
use App\Models\User;
use App\Services\FakeStoreAPIService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{
    public function index(){    
        return view('dashboard/home');
    }

    public function logout(Request $request)
    {
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken(); 
    
        return redirect()->route('home'); 
    }

    public function perfil(){
        $user = User::where('id', Auth::user()->id)->first();
        return view('dashboard/perfil', ['user' => $user]);
    }

    public function update(Request $request){
        /** @var User $user */

        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,'.$user->id,
            'phone' => 'required|string|max:11|min:11',
            'password' => 'nullable|string'
        ]);
    
        $updateData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone']
        ];
    
        if (!empty($validated['password'])) {
            $updateData['password'] = Hash::make($validated['password']);
        }
    
        $user->update($updateData);
    
        return redirect()->route('dashboard')->with('success', 'Perfil atualizado com sucesso!');
    }

    public function import(){
        $fakeStoreApi = new FakeStoreAPIService;
        $apiProducts = $fakeStoreApi->getProducts();
        
        $existingProducts = Product::where('deleted', 0)
        ->get(['name', 'description', 'price', 'image_url']);
                
        $filteredProducts = array_filter($apiProducts, function ($apiProduct) use ($existingProducts) {
            $processedData = [
                'name' => trim(preg_replace('/\s+/', ' ', $apiProduct['title'])),
                'price' => round(floatval($apiProduct['price']), 2),
                'description' => strip_tags($apiProduct['description']),
                'image_url' => filter_var($apiProduct['image'], FILTER_VALIDATE_URL) ? $apiProduct['image'] : null
            ];
            
            foreach ($existingProducts as $existing) {
                if (
                    $existing->name === $processedData['name'] &&
                    $existing->description === $processedData['description'] &&
                    $existing->price == $processedData['price'] && 
                    $existing->image_url === $processedData['image_url']
                ) {
                    return false; 
                }
            }
            return true; 
        });
        return view('dashboard/import', ['products' => $filteredProducts]);
    }

    public function importStore(Request $request){
        $import = new ImportProductJob($request->id);
        $repository = app(\App\Repositories\ProductAPIRepository::class);
        $service = app(FakeStoreAPIService::class);
        $import->handle($service, $repository);
        return redirect()->back()->with('success', 'Produto importado com sucesso!');
    }

    public function importAll(Request $request){
        $fakeStoreApi = new FakeStoreAPIService;
        $apiProducts = $fakeStoreApi->getProducts();
        
        $existingProducts = Product::where('deleted', 0)
        ->get(['name', 'description', 'price', 'image_url']);
        
        $filteredProducts = array_filter($apiProducts, function ($apiProduct) use ($existingProducts) {
            $processedData = [
                'name' => trim(preg_replace('/\s+/', ' ', $apiProduct['title'])),
                'price' => round(floatval($apiProduct['price']), 2),
                'description' => strip_tags($apiProduct['description']),
                'image_url' => filter_var($apiProduct['image'], FILTER_VALIDATE_URL) ? $apiProduct['image'] : null
            ];
            
            foreach ($existingProducts as $existing) {
                if (
                    $existing->name === $processedData['name'] &&
                    $existing->description === $processedData['description'] &&
                    $existing->price == $processedData['price'] && 
                    $existing->image_url === $processedData['image_url']
                ) {
                    return false;
                }
            }
            return true;
        });
    
        foreach ($filteredProducts as $product) {
            $importProductJob = new ImportProductJob($product['id']);
            $repository = app(\App\Repositories\ProductAPIRepository::class);
            $service = app(FakeStoreAPIService::class);
            $importProductJob->handle($service, $repository);
            ImportProductJob::dispatch($product['id']); 
        }
    
        return redirect()->back()->with(
            'success', 
            count($filteredProducts) . ' produtos foram enfileirados para importação!'
        );
    }
}
