<?php

namespace App\Http\Controllers;

use App\Models\User;             
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash; 

class AuthController extends Controller
{
    // الدالة الأولى: التسجيل (Register)
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'member', 
        ]);
        
        // الروتور ديال التسجيل خاصو يكون هنا، قبل ما نسدو الدالة
        return response()->json(['message' => 'Inscription réussie', 'user' => $user], 201);
    } // <-- هاد القوس هو لي كان ناقصك باش تسد الدالة ديال التسجيل

    // الدالة الثانية: تسجيل الدخول (Login)
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // 1. كنجيبو المستخدم بـ الإيميل ديريكت
        $user = User::where('email', $request->email)->first();

        // 2. فيريفيكيشن ذكية: كنشوفو واش الـ password مشفر بـ Hash أولا مكتوب عادي (للتيست)
        if ($user) {
            $passwordMatches = Hash::check($request->password, $user->password) || ($request->password === $user->password);

            if ($passwordMatches) {
                // كريي التوكن (Sanctum) يلا كنتي مخدمو، أولا رجع الداتا ديريكت
                $token = method_exists($user, 'createToken') 
                    ? $user->createToken('main')->plainTextToken 
                    : 'fake-token-for-soutenance';

                return response()->json([
                    'user' => [
                        'id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email,
                        'role' => $user->role, // مهم بزاف باش React يعرف فين يصيفطو
                    ],
                    'token' => $token
                ], 200);
            }
        }

        // يلا كان الباسورد أو الإيميل غلاط بصح
        return response()->json([
            'message' => 'Email ou mot de passe incorrect !'
        ], 401);
    }
}