<?php

namespace App\Http\Controllers;

use App\Models\Equipement;
use Illuminate\Http\Request;

class EquipementController extends Controller
{
    public function index()
    {
        return response()->json(Equipement::all());
    }

    public function store(Request $request)
    {
        $equipement = Equipement::create($request->all());
        return response()->json($equipement, 201);
    }

    public function update(Request $request, $id)
    {
        $equipement = Equipement::findOrFail($id);
        $equipement->update($request->all());
        return response()->json($equipement);
    }

    public function destroy($id)
    {
        Equipement::destroy($id);
        return response()->json(['message' => 'Supprimé avec succès']);
    }
}