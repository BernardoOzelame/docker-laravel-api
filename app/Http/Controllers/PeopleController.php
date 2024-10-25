<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePeopleRequest;
use App\Models\People;
use Illuminate\Http\Request;

class PeopleController extends Controller {
    public function list(Request $request) {
        return response()->json([
            'pessoasEncontradas' => People::all()->count(),  // retorna a quantidade de pessoas encontradas
            // 'brasileiros' => People::where('country', 'Brasil')->get(), // retorna a quantidade de people brasileiras
            // 'people' => People::all(), // retorna todas as people (informações)
            'paginacao' => People::paginate(10) // retorna as people paginadas
        ]);
    }

    public function store(StorePeopleRequest $people) {
        return true;
    }
}
