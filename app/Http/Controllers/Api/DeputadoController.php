<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Deputado;

class DeputadoController extends Controller
{
    public function index(Request $request) {

        $query = Deputado::query();

        if ($request->has('search')) {
            $query->where('nome', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('sigla_uf')){
            $query->where('sigla_uf', $request->sigla_uf);
        }

        if ($request->filled('sigla_partido')) {
            $query->where('sigla_partido', $request->sigla_partido);
        }

        $deputados = $query->paginate(12);



        $ufs = Deputado::select('sigla_uf')->distinct()->orderBy('sigla_uf')->pluck('sigla_uf');
        $partidos = Deputado::select('sigla_partido')->distinct()->orderBy('sigla_partido')->pluck('sigla_partido');

        return response()->json([
            'data' => $deputados,
            'ufs' => $ufs,
            'partidos' => $partidos
        ]);
    }

    public function show($id)
    {
        $deputado = Deputado::with('ocupacoes', 'profissoes')->findOrFail($id);

        return response()->json($deputado);
    }

    public function outrosDeputadosDoEstado($id)
    {
        $deputado = Deputado::findOrFail($id);

        $outros = Deputado::where('sigla_uf', $deputado->sigla_uf)
            ->where('id', '!=', $id)
            ->orderBy('nome')
            ->limit(6)
            ->get();

        return response()->json($outros);
    }

}
