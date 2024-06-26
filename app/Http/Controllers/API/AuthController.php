<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            $user = User::with(['worker', 'worker.offers', 'worker.degrees', 'worker.jobs', 'worker.experiencies', 'worker.skills'])->where('email', $request->email)->firstOrFail();
            $token = $user->createToken('authToken')->plainTextToken;
            return response()->json([
                'token' => $token,
                'user' => $user
            ], 200);
        }

        throw ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect.'],
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json(['message' => 'Logged out successfully'], 200);
    }

    public function me(Request $request)
    {
        $user = User::with(['worker', 'worker.file', 'worker.offers', 'worker.degrees', 'worker.jobs', 'worker.experiencies', 'worker.skills'])
            ->findOrFail($request->user()->id);

        // Obtener la URL de la imagen de perfil si está disponible
        $profilePhotoUrl = null;
        if ($user->worker && $user->worker->file) {
            $profilePhotoUrl = Storage::url($user->worker->file->filename);
        }

        $user->profile_photo_url = $profilePhotoUrl;

        return response()->json(['user' => $user], 200);
    }
}
