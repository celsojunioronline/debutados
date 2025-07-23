<?php

namespace App\Livewire;

use App\Models\Deputado;
use App\Models\Despesa;
use Livewire\Component;
use Livewire\WithPagination;

class ShowDespesas extends Component
{
    use WithPagination;
    public $deputadoId;
    public $search = '';
    protected $paginationTheme = 'bootstrap';

    public function mount($id)
    {
        $this->deputadoId = $id;
    }

    public function render()
    {
        $deputado = Deputado::findOrFail($this->deputadoId);

        $despesas = Despesa::where('deputado_id', $this->deputadoId)
            ->where(function($query) {
                $query->where('tipo_despesa', 'like', '%' . $this->search . '%')
                    ->orWhere('nome_fornecedor', 'like', '%' . $this->search . '%');
            })
            ->orderByDesc('data_documento')
            ->paginate(10);

        return view('livewire.show-despesas', [
            'deputado' => $deputado,
            'despesas' => $despesas,
        ])->layout('layouts.app');
    }
}
