<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\Auth;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('vistas.usuarios.usuario');
    }

    public function listado()
    {
        $users = User::where('id', '<>', Auth::id())->get();
        $roles = Role::where('id', '!=', 1)->get();

        return response()->json([
            'users' => $users,
            'roles' => $roles,
        ]);
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
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'role_id' => 'required|exists:roles,id',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = new User();
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->role_id = $validated['role_id'];
        $user->password = Hash::make($validated['password']);
        $user->save();

        if ($request->ajax()) {
            return response()->json(['message' => 'Usuario creado correctamente.'], 201);
        }

        return redirect()->route('users.index')->with('success', 'Usuario creado correctamente.');
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
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => "required|email|unique:users,email,{$id}",
            'role_id' => 'required|exists:roles,id',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user = User::findOrFail($id);
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->role_id = $validated['role_id'];

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        if ($request->ajax()) {
            return response()->json(['message' => 'Usuario actualizado con éxito.']);
        }

        return redirect()->route('users.index')->with('success', 'Usuario actualizado con éxito.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //solo se actulizara el campo deleted_at
        $user->deleted_at = now();
        $user->save();

        if ($request->ajax()) {
            return response()->json(['message' => 'Usuario eliminado con éxito.']);
        }

        return redirect()->route('users.index')->with('success', 'Usuario eliminado con éxito.');
    }
}
