<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index()
    {
        $users = DB::table('users')
            ->get()
            ->toArray();

        return response()->json([
            'status' => 'Success', 'data' => $users,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|max:250',
            'prenom' => 'required|max:250',
        ]);

        $user = User::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            
        ]);

        return response()->json([
            'status' => 'Success', 
            'data' => $user,
        ]);
    }

    public function show(User $user)
    {
        return response()->json($user);
    }

    public function update(Request $request, User $user)
    {   
        $request->validate([
            'nom' => 'max:250',
            'prenom' => 'max:250',
        ]);

        $updatedData = array_filter($request->all());
        $user->update($updatedData);
        
        return response()->json([
            'status' => 'Update Successfully', 
            'data' => $user,
        ]);

    }

    public function destroy(User $user)
    {
        $user->delete();

        return response()->json([
            'status' => 'Delete Successfully'
        ]);
    }
}
