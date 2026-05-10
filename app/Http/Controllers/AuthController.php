<?php

namespace App\Http\Controllers;

use App\Models\Utilisateur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            ‘username’ => ‘required|string|max:50|unique:utilisateurs,username’,
            ‘email’ => ‘required|string|email|max:255|unique:utilisateurs,email’,
            ‘mot_de_passe’ => ‘required|string|min:8|confirmed’,
        ]);

        $utilisateur = new Utilisateur();
        $utilisateur->username = $request->username;
        $utilisateur->email = $request->email;
        $utilisateur->password = $request->mot_de_passe;
        $utilisateur->save();

        return response()->json([‘message’ => ‘Utilisateur enregistré avec succès’], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            ‘email’ => ‘required|email’,
            ‘password’ => ‘required’,
        ]);

        $user = Utilisateur::where(‘email’, $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->mot_de_passe)) {
            throw ValidationException::withMessages([
                ‘email’ => [‘Les informations d\’identification sont incorrectes’],
            ]);
        }

        return response()->json([
            ‘token’ => $user->createToken(‘auth_token’)->plainTextToken,
            ‘user’ => $user,
        ]);
    }
}
