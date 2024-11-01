<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInterestsRequest;
use App\Http\Requests\StorePeopleRequest;
use App\Models\Interests;
use App\Models\People;
use Illuminate\Http\Request;

class PeopleController extends Controller {
    public function list(Request $request) {
        return response()->json([
            'pessoasEncontradas' => People::all()->count(),  // retorna a quantidade de pessoas encontradas
            // 'brasileiros' => People::where('country', 'Brasil')->get(), // retorna a quantidade de people brasileiras
            // 'people' => People::all(), // retorna todas as people (informações)
            'paginacao' => People::with('interests')->paginate(10) // retorna as people paginadas
        ]);
    }

    public function store(StorePeopleRequest $people) {
        $newPeople = People::create($people->all());
        if ($newPeople) {
            return response()->json([
                'message' => 'Pessoa cadastrada com sucesso!',
                'pessoa' => $newPeople
            ]);
        } else {
            return response()->json([
                'message' => 'Erro ao cadastrar pessoa'
            ], 422);
        } // Só uma OBS: o return que está dentro do else pode ficar fora, sem a necessidade do else
    }

    public function storeInterests(StoreInterestsRequest $interests){
        $newInterest = Interests::create($interests->all());
        if ($newInterest) {
            return response()->json([
                'message' => 'Interesse cadastrado com sucesso!',
                'interesse' => $newInterest
            ]);
        } else {
            return response()->json([
                'message' => 'Erro ao cadastrar interesse'
            ], 422);
        }
    }
}
