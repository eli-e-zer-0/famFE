<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class almacenamientoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        return view('vistas.almacenamiento.almacenamiento');
    }

    public function data()
    {
        try {
            $productos = DB::table('vws_Almacenamiento')->get();

            Log::info('Productos: ' . $productos);

            $headers = [];
            $rows = [];

            if ($productos->count() > 0) {
                $headers = array_keys((array) $productos->first());

                foreach ($productos as $producto) {
                    $rows[] = (array) $producto;
                }
            }

            // agregamos columna encabezados
            // $headers[] = 'Acciones';

            return response()->json(['headers' => $headers, 'rows' => $rows], 200);
        } catch (\Exception $e) {
            Log::error('Error fetching almacenamiento data: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to fetch data'], 500);
        }
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
        //
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
        Log::info("Eliminando producto con ID:" . $id);

        return response()->json(['message' => 'Producto eliminado'], 200);
    }
}
