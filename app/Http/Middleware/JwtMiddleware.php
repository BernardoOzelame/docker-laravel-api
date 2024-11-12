<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class JwtMiddleware { // recebe uma requisição, se tiver tudo OK, passa para a próxima requisição
    public function handle(Request $request, Closure $next): Response {
        try {
            JWTAuth::parseToken()->authenticate();
        } catch (JWTException $e) {
            return response()->json([
                'error' => 'Token inválido!'
            ], 401);
        }

        return $next($request); // antes de passar para a próxima requisição, neste caso, tem que verificar se está logado (tem token)
    }
}
