<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Projet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProjetController extends Controller
{

    public function index()
    {
        $projets = DB::table('projets')
            ->get()
            ->toArray();

        return response()->json([
            'status' => 'Success', 'data' => $projets,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|max:250',
            'description' => 'required',
            'date_debut' => 'required|date|date_format:d/m/Y',
            'date_fin' => 'required|date|date_format:d/m/Y',
            'avancement' => 'required|integer',
        ]);

        $projet = Projet::create([
            'nom' => $request->nom,
            'description' => $request->description,
            'date_debut' => $request->date_debut,
            'date_fin' => $request->date_fin,
            'avancement' => $request->avancement,
        ]);

        return response()->json([
            'status' => 'Success', 
            'data' => $projet,
        ]);
    }

    public function show(Projet $projet)
    {
        return response()->json($projet);
    }

    public function update(Request $request, Projet $projet)
    {
        $request->validate([
            'nom' => 'required|max:250',
            'description' => 'required',
            'date_debut' => 'required|date|date_format:d/m/Y',
            'date_fin' => 'required|date|date_format:d/m/Y',
            'avancement' => 'required|integer',
        ]);

        $projet->update([
            'nom' => $request->nom,
            'description' => $request->description,
            'date_debut' => $request->date_debut,
            'date_fin' => $request->date_fin,
            'avancement' => $request->avancement,
        ]);

        return response()->json([
            'status' => 'Update Successfully', 
            'data' => $projet,
        ]);

    }

    public function destroy(Projet $projet)
    {
        $projet->delete();

        return response()->json([
            'status' => 'Delete Successfully'
        ]);
    }
}
