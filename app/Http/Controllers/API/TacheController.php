<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\Tache;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TacheController extends Controller
{
    public function index()
    {
        $taches = Tache::with('projet', 'documents')
            ->get()
            ->toArray();

        return response()->json([
            'status' => 'Success', 
            'data' => $taches,
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
            'projet_id' => 'required',
        ]);

        $tache = Tache::create([
            'nom' => $request->nom,
            'description' => $request->description,
            'date_debut' => $request->date_debut,
            'date_fin' => $request->date_fin,
            'avancement' => $request->avancement,
            'projet_id' => $request->projet_id,
        ]);

        if($request->has('file')){
            $file = $request->file;
            
            $filenameWithExt = $file->getClientOriginalName();
            $filenameWithoutExt = pathinfo($filenameWithExt, PATHINFO_FILENAME);

            $extension = $file->getClientOriginalExtension();
            $filename = $filenameWithoutExt . '_' . time() . '.' . $extension;

            $path = $file->storeAs('public/uploads', $filename);

            $document = Document::create([
                'nom' => $filenameWithoutExt,
                'url' => $path,
                'tache_id' => $tache->id
            ]);
        }

        return response()->json([
            'status' => 'Success', 
            'data' => $tache,
        ]);
    }

    public function show(Tache $tach)
    {
        $tach->projet = $tach->projet()->get()->toArray();
        $tach->documents = $tach->documents()->get()->toArray();
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
            'projet_id' => '',
        ]);

        $updatedData = array_filter($request->all());

        $tach->update($updatedData);
        
        if($request->has('file')){
            $documents = Document::where('tache_id', $tach->id);
            $documents->delete();

            foreach ($request->file as $file) {
                $filenameWithExt = $file->getClientOriginalName();
                $filenameWithoutExt = pathinfo($filenameWithExt, PATHINFO_FILENAME);

                $extension = $file->getClientOriginalExtension();
                $filename = $filenameWithoutExt . '_' . time() . '.' . $extension;

                $path = $file->storeAs('public/uploads', $filename);

                $document = Document::create([
                    'nom' => $filenameWithoutExt,
                    'url' => $path,
                    'tache_id' => $tach->id
                ]);
            }
        }

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
