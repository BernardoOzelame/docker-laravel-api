<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class JWTAuthController extends Controller {
    public function register(Request $request) {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|string|unique:users|max:255',
            'password' => 'required|string|min:6|confirmed'
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password'])
        ]);

        $token = JWTAuth::fromUser($user);

        return response()->json(compact('user', 'token'), 201);
    }

    public function login(Request $request) {
        $cred = $request->only('email', 'password');
        
        try {
            // se o login não funcionar
            if (!JWTAuth::attempt($cred)) {
                return response()->json([
                    'error' => 'Credenciais Inválidas!'
                ], 400);
            }

            // se chegou aqui, deu certo!
            $user = auth()->user(); // pode ser JWTAuth::user();

            // no caso de atribuição de um papel para um usuário (admin, editor, gerente, ...)
            // $token = JWTAuth::claims(['role' => $user->role])->fromUser($user);
            $token = JWTAuth::fromUser($user);
            return response()->json([
                compact('token')
            ]);
        
        } catch (JWTException $e) {
            return response()->json([
                'error' => 'Erro interno!'
            ], 500);
        }
    }

    public function logout() {
        JWTAuth::invalidate(JWTAuth::getToken());
        return response()->json([
            'message' => 'Deslogado com sucesso!'
        ]);
    }
}
