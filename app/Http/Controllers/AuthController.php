<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

/**
 * @OA\Info(
 *     version="1.0.0",
 *     title="API Booking Lapangan Futsal",
 *     description="Dokumentasi API untuk aplikasi booking futsal"
 * )
 *
 * @OA\Tag(
 *     name="Auth",
 *     description="API untuk autentikasi pengguna"
 * )
 */
class AuthController extends Controller
{
    /**
     * @OA\PathItem(
     *     path="/api/register"
     * )
     *
     * @OA\Post(
     *     path="/api/register",
     *     tags={"Auth"},
     *     summary="Registrasi pengguna baru",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name","email","password","password_confirmation"},
     *             @OA\Property(property="name", type="string", example="John Doe"),
     *             @OA\Property(property="email", type="string", format="email", example="john@example.com"),
     *             @OA\Property(property="password", type="string", format="password", example="secret123"),
     *             @OA\Property(property="password_confirmation", type="string", format="password", example="secret123")
     *         )
     *     ),
     *     @OA\Response(response=201, description="User berhasil didaftarkan"),
     *     @OA\Response(response=422, description="Validasi error")
     * )
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        return response()->json($user, 201);
    }

    /**
     * @OA\PathItem(
     *     path="/api/login"
     * )
     *
     * @OA\Post(
     *     path="/api/login",
     *     tags={"Auth"},
     *     summary="Login pengguna",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email","password"},
     *             @OA\Property(property="email", type="string", example="john@example.com"),
     *             @OA\Property(property="password", type="string", format="password", example="secret123")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil login",
     *         @OA\JsonContent(
     *             @OA\Property(property="token", type="string", example="eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9...")
     *         )
     *     ),
     *     @OA\Response(response=401, description="Email atau password salah")
     * )
     */
    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $validated['email'])->first();

        if (!$user || !Hash::check($validated['password'], $user->password)) {
            return response()->json(['message' => 'Email atau password salah'], 401);
        }

        $token = $user->createToken('api_token')->plainTextToken;

        return response()->json(['token' => $token]);
    }

    /**
     * @OA\PathItem(
     *     path="/api/logout"
     * )
     *
     * @OA\Post(
     *     path="/api/logout",
     *     tags={"Auth"},
     *     summary="Logout pengguna",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(response=200, description="Berhasil logout")
     * )
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Berhasil logout']);
    }
}
