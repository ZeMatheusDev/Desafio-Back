<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use Illuminate\Http\Request;

class CategorieController extends Controller
{
    public function index(Request $request){
        $categories = Categorie::where('deleted', 0);
        if($request->method() == 'POST'){
            if($request->name != ''){
                $categories->where('name', $request->name);
            }
        }
        $categories = $categories->get();
        return view('/categorie/list')->with('categories', $categories);
    }

    public function create(){
        return view('/categorie/create');
    }
    
    public function store(Request $request){
        $validated = $request->validate([
            'name' => 'required|string|max:255'
        ]);
    
        Categorie::create([
            'name' => $validated['name'],
            'deleted' => 0
        ]);
    
        return redirect()->route('categorie.list')->with('success', 'Categoria criada com sucesso!');
    }

    public function delete(Request $request){
        Categorie::where('id', $request->id)->update(['deleted' => 1]);

        return redirect()->route('categorie.list')->with('success', 'Categoria deletada com sucesso!');
    }

    public function edit($id){
        $categorie = Categorie::where('id', $id)->first();
        
        return view('/categorie/edit')->with('categorie', $categorie);
    }

    public function update(Request $request){
        $validated = $request->validate([
            'name' => 'required|string|max:255'
        ]);

        Categorie::where('id', $request->id)->update(['name' => $validated['name']]);
    
        return redirect()->route('categorie.list')->with('success', 'Categoria editada com sucesso!');
    }
}
