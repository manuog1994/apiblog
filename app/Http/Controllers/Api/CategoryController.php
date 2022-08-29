<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Resources\CategoryResource;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::included()
                        ->filter()
                        ->sort()
                        ->getOrPaginate(); // Score creado para que el cliente decida si quiere paginar o no
        //retornamos toda la coleccion de categorias a traves de la clase CategoryResource
        return CategoryResource::collection($categories);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'slug' => 'required|max:255|unique:categories', 
        ]);

        $category = Category::create($request->all());

        return CategoryResource::make($category);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */

    // // De esta forma nos evitamos usar el metodo findOrFail()
    // public function show(Category $category)
    // {
    //     return $category;
    // }

    public function show($id)
    {
        $category = Category::included()->findOrFail($id);
        // retornamos el objeto según este definida en CategoryResource
        return CategoryResource::make($category);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        // validamos la información que se quiere actualizar

        $request->validate([
            'name' => 'required|max:255',
            // de esta forma evitamos que se actualice el slug si no se cambia el nombre
            'slug' => 'required|max:255|unique:categories,slug,' . $category->id,
        ]);

        // actualizamos la información
        $category->update($request->all());

        // retornamos la información actualizada
        return CategoryResource::make($category);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return CategoryResource::make($category);
    }
}
