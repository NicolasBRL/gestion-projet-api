<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Tache;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TacheController extends Controller
{
    public function index()
    {
        $taches = DB::table('taches')
            ->get()
            ->toArray();

        return response()->json([
            'status' => 'Success', 'data' => $taches,
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

        $tache = Tache::create([
            'nom' => $request->nom,
            'description' => $request->description,
            'date_debut' => $request->date_debut,
            'date_fin' => $request->date_fin,
            'avancement' => $request->avancement,
        ]);

        

        return response()->json([
            'status' => 'Success', 
            'data' => $tache,
        ]);
    }

    public function show(Tache $tach)
    {
        return response()->json($tach);
    }

    public function update(Request $request, Tache $tach)
    {   
        $request->validate([
            'nom' => 'max:250',
            'description' => '',
            'date_debut' => 'date',
            'date_fin' => 'date',
            'avancement' => 'integer',
        ]);

        $updatedData = array_filter($request->all());

        $tach->update($updatedData);
        
        return response()->json([
            'status' => 'Update Successfully', 
            'data' => $tach,
        ]);

    }

    public function destroy(Tache $tach)
    {
        $tach->delete();

        return response()->json([
            'status' => 'Delete Successfully'
        ]);
    }
}
