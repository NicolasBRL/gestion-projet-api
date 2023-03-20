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
        //
    }

    public function show(Tache $tache)
    {
        //
    }

    public function update(Request $request, Tache $tache)
    {
        //
    }

    public function destroy(Tache $tache)
    {
        //
    }
}
