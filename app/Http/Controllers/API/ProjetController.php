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
        $projets = Projet::with('users', 'taches')->get()->toArray();

        return response()->json([
            'status' => 'Success', 
            'data' => $projets,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|max:250',
            'description' => 'required',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date',
            'avancement' => 'required|integer',
        ]);

        $projet = Projet::create([
            'nom' => $request->nom,
            'description' => $request->description,
            'date_debut' => $request->date_debut,
            'date_fin' => $request->date_fin,
            'avancement' => $request->avancement,
        ]);

        $projet->users()->attach($request->user_id);

        return response()->json([
            'status' => 'Success', 
            'data' => $projet,
        ]);
    }

    public function show(Projet $projet)
    {
        $projet->users = $projet->users()->get()->toArray();
        $projet->taches = $projet->taches()->get()->toArray();
        return response()->json($projet);
    }

    public function update(Request $request, Projet $projet)
    {   
        $request->validate([
            'nom' => 'max:250',
            'description' => '',
            'date_debut' => 'date',
            'date_fin' => 'date',
            'avancement' => 'integer',
        ]);

        $updatedData = array_filter($request->all());

        $projet->update($updatedData);
        $projet->users()->sync($request->user_id);
        
        return response()->json([
            'status' => 'Update Successfully', 
            'data' => $projet,
        ]);

    }

    public function destroy(Projet $projet)
    {
        $projet->users()->detach();
        $projet->delete();

        return response()->json([
            'status' => 'Delete Successfully'
        ]);
    }
}
