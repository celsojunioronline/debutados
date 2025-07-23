<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Despesa;

class DespesaController extends Controller
{
    public function index($id, Request $request)
    {
        try {
            // Base da consulta com filtro de busca
            $query = Despesa::where('deputado_id', $id);

            if ($request->filled('search')) {
                $query->where(function ($q) use ($request) {
                    $q->where('tipo_despesa', 'like', '%' . $request->search . '%')
                        ->orWhere('nome_fornecedor', 'like', '%' . $request->search . '%');
                });
            }

            // Despesas paginadas para tabela
            $despesas = $query->orderByDesc('data_documento')->paginate(10);

            // Total gasto no mês atual
            $totalMes = Despesa::where('deputado_id', $id)
                ->whereNotNull('data_documento')
                ->whereMonth('data_documento', now()->month)
                ->sum('valor_documento');

            // Total de transações no ano atual
            $totalAno = Despesa::where('deputado_id', $id)
                ->whereNotNull('data_documento')
                ->whereYear('data_documento', now()->year)
                ->count();

            // Média mensal de gastos no ano atual
            $mediaMensal = Despesa::where('deputado_id', $id)
                ->whereNotNull('data_documento')
                ->selectRaw('SUM(valor_documento) as total, MONTH(data_documento) as mes')
                ->groupByRaw('MONTH(data_documento)')
                ->pluck('total')
                ->avg();


            // Gráfico pizza: tipos de despesa
            $pizza = Despesa::where('deputado_id', $id)
                ->whereNotNull('tipo_despesa')
                ->selectRaw('tipo_despesa, SUM(valor_documento) as total')
                ->groupBy('tipo_despesa')
                ->orderByDesc('total')
                ->get();

            return response()->json([
                'despesas' => $despesas,
                'totalMes' => round($totalMes, 2),
                'totalAno' => $totalAno,
                'mediaMensal' => round($mediaMensal, 2),
                'pizza' => $pizza,
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'error' => 'Erro ao buscar despesas',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
