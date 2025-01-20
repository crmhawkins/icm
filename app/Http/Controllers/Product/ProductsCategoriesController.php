<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\Tpv\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductsCategoriesController extends Controller
{
    public function index()
    {
        $servicios = Category::paginate(2);
        return view('products-categories.index', compact('servicios'));
    }

    public function create() {
        return view('products-categories.create');
    }

    public function store(Request $request) {
        // Validamos los campos
        $data = $this->validate($request, [
            'name' => 'required|max:255',
            'inactive' => 'nullable',
        ], [
            'name.required' => 'El nombre es requerido para continuar',
            'name.max' => 'El nombre no pueder tener mas de 255 caracteres',
        ]);


        if($request->hasFile('image')){
            $imagen = $request->file('image')->store('public/categories');
            $data['image'] = Storage::url($imagen);
        }
        $categoriaCreada = Category::create($data);

        if($categoriaCreada){
            return redirect()->route('productosCategoria.edit', $categoriaCreada->id)->with('toast', [
                    'icon' => 'success',
                    'mensaje' => 'El categoria creada con exito'
            ]);
        }else{
            return redirect()->back()->with('toast', [
                'icon' => 'error',
                'mensaje' => 'Error en la creacion de la categoria'
            ]);
        }

    }

    public function edit(string $id){
        $categoria = Category::find($id);
        if (!$categoria) {
            session()->flash('toast', [
                'icon' => 'error',
                'mensaje' => 'La categoria no existe'
            ]);
            return redirect()->route('productosCategoria.index');
        }
        return view('products-categories.edit', compact('categoria'));
    }

    public function update(string $id ,Request $request) {
        $categoria = Category::find($id);
        $data = $this->validate($request, [
            'name' => 'required|max:255',
            'inactive' => 'nullable'
        ], [
            'name.required' => 'El nombre es requerido para continuar',
            'name.max' => 'El nombre no pueder tener mas de 255 caracteres',
        ]);

        if($request->hasFile('image')){
            $imagen = $request->file('image')->store('public/categories');
            $data['image'] = Storage::url($imagen);
        }

        $categoriaCreada = $categoria->update($data);

        return redirect()->route('productosCategoria.index')->with('toast', [
                'icon' => 'success',
                'mensaje' => 'El servicio actualizado con exito'
        ]);
    }

    public function destroy(Request $request) {
        $servicio = Category::find($request->id);

        if (!$servicio) {
            return response()->json([
                'error' => true,
                'mensaje' => "Error en el servidor, intentelo mas tarde."
            ]);
        }

        $servicio->delete();

        return response()->json([
            'error' => false,
            'mensaje' => 'La categoria de servicio fue borrada correctamente'
        ]);
    }


}
