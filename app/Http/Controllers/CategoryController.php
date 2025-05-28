<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Auth::user()->categories;
        return view('category.list', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('category-create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {   
               
        $validated = $request->validate([
            'name' => 'required|string|max:255', 
        ]);

        $validated['user_id'] = Auth::id();
        $category = Category::create($validated);

        return response()->json([
            "category" => $category,
            "message" => "Categoria {$category->name} criada com sucesso!"
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return view('category-show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view('category-edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
       $category->update([
              'name' => $request->name,
       ]);

       return response()->json([
           "redirect" => url("/app")
       ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return redirect('/')->with('message', 'Categoria '. $category->name . ' apagada com successo!' );
    }
}
