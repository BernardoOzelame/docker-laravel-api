<?php

use App\Http\Controllers\JWTAuthController;
use App\Http\Controllers\PeopleController;
use App\Http\Middleware\JwtMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json([
        'message' => 'OK!'
    ]);
});

Route::get('/somar', function(Request $request) {
    // não está chegando nada pela request
    if (count($request->all()) < 1) {
        return response()->json([
            'message' => 'Não há valores para somar.'
        ], 406); // 406 é o código do erro
    }

    $soma = array_sum($request->all());
    return response()->json([
        'message' => 'Somado com sucesso!', // Opcional
        'sum' => $soma,
    ]);
});

Route::prefix('/people')->middleware([JwtMiddleware::class])->group(function() {
    Route::get('/list', [PeopleController::class, 'list']);
    Route::post('/store', [PeopleController::class, 'store']);
    Route::post('/storeInterests', [PeopleController::class, 'storeInterests']);
});

Route::prefix('/user')->group(function() {
    Route::post('/register', [JWTAuthController::class, 'register']);
    Route::post('/login', [JWTAuthController::class, 'login']);
    Route::middleware([JwtMiddleware::class])->get('/logout', [JWTAuthController::class, 'logout']);
});