<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AuthController extends Controller
{
    /**
     * Login endpoint - validates credentials and returns auth token
     */
    public function login(Request $request)
    {
        try {
            $validated = $request->validate([
                'email' => 'required|email',
                'password' => 'required|string',
            ]);

            $user = User::where('email', $validated['email'])->first();

            // Check if user exists and password is correct
            if (!$user || !Hash::check($validated['password'], $user->password)) {
                return response()->json([
                    'error' => 'Las credenciales proporcionadas son inválidas.'
                ], Response::HTTP_UNAUTHORIZED);
            }

            // Check if user is active (not soft deleted)
            if ($user->trashed()) {
                return response()->json([
                    'error' => 'Esta cuenta ha sido desactivada.'
                ], Response::HTTP_FORBIDDEN);
            }

            // Create Sanctum token
            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'message' => 'Autenticación exitosa',
                'token' => $token,
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $user->role,
                    'profile_photo' => $user->profile_photo,
                ]
            ], Response::HTTP_OK);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['errors' => $e->errors()], Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Logout endpoint - revokes the current token
     */
    public function logout(Request $request)
    {
        try {
            $request->user()->currentAccessToken()->delete();
            return response()->json(['message' => 'Sesión cerrada exitosamente'], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Get current authenticated user
     */
    public function me(Request $request)
    {
        try {
            $user = $request->user();
            return response()->json([
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
                'department' => $user->department,
                'profile_photo' => $user->profile_photo,
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Update the authenticated user's profile (name, password)
     */
    public function updateProfile(Request $request)
    {
        try {
            $user = $request->user();
            $changed = false;

            // Update name
            if ($request->has('name') && $request->input('name') !== $user->name) {
                $user->name = $request->input('name');
                $changed = true;
            }

            // Update password
            if ($request->filled('new_password')) {
                $currentPassword = $request->input('current_password');
                $newPassword = $request->input('new_password');
                $confirmPassword = $request->input('new_password_confirmation');

                if (!$currentPassword) {
                    return response()->json(['message' => 'Debes ingresar tu contraseña actual.'], Response::HTTP_UNPROCESSABLE_ENTITY);
                }

                if (!Hash::check($currentPassword, $user->password)) {
                    return response()->json(['message' => 'La contraseña actual es incorrecta.'], Response::HTTP_UNPROCESSABLE_ENTITY);
                }

                if ($newPassword !== $confirmPassword) {
                    return response()->json(['message' => 'Las contraseñas nuevas no coinciden.'], Response::HTTP_UNPROCESSABLE_ENTITY);
                }

                $user->password = Hash::make($newPassword);
                $changed = true;
            }

            if (!$changed) {
                return response()->json(['message' => 'No hay cambios para guardar.'], Response::HTTP_OK);
            }

            $user->save();

            return response()->json([
                'message' => 'Perfil actualizado exitosamente',
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $user->role,
                    'profile_photo' => $user->profile_photo,
                ]
            ], Response::HTTP_OK);

        } catch (\Exception $e) {
            return response()->json(['message' => 'Error interno: ' . $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Upload profile photo for the authenticated user
     */
    public function uploadProfilePhoto(Request $request)
    {
        try {
            $user = $request->user();

            if (!$request->hasFile('photo')) {
                return response()->json(['message' => 'No se detectó ningún archivo.'], Response::HTTP_BAD_REQUEST);
            }

            $file = $request->file('photo');

            if (!$file->isValid()) {
                return response()->json(['message' => 'El archivo subido es inválido.'], Response::HTTP_BAD_REQUEST);
            }

            $path = $file->store('profile_photos', 'public');

            $user->profile_photo = Storage::url($path);
            $user->save();

            return response()->json([
                'message' => 'Foto de perfil actualizada exitosamente',
                'profile_photo' => $user->profile_photo,
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $user->role,
                    'profile_photo' => $user->profile_photo,
                ]
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error interno: ' . $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
