<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\inventarioModel;
use Illuminate\Support\Facades\Log;

class inventarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // retornar a la vista
        return view('vistas.inventario.inventario');
    }

    // funcion para obtener los datos de la tabla inventario
    public function data()
    {
        $datos = inventarioModel::all();
        return response()->json($datos);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
