<?php

namespace App\Http\Controllers;

use App\Models\Utilisateur;

class UserController extends Controller
{
    public function index()
    {
        $users = Utilisateur::with('roles')->get();
        return response()->json($users);
    }
}
