<?php

namespace App\Livewire;

use App\Models\Deputado;
use Livewire\Component;
use Livewire\WithPagination;

class DeputadosList extends Component
{
    use WithPagination;

    public $search = '';
    public $sigla_uf = '';
    public $sigla_partido = '';
    public $ufs = [];
    public $partidos = [];
    protected $paginationTheme = 'bootstrap';

    public function mount()
    {
        $this->ufs = Deputado::select('sigla_uf')->distinct()->pluck('sigla_uf')->filter()->values()->toArray();
        $this->partidos = Deputado::select('sigla_partido')->distinct()->pluck('sigla_partido')->filter()->values()->toArray();
    }
    public function render()
    {
        $deputados = Deputado::query()
            ->when($this->search, fn ($q) => $q->where('nome', 'like', '%' . $this->search . '%'))
            ->when($this->sigla_uf, fn ($q) => $q->where('sigla_uf', $this->sigla_uf))
            ->when($this->sigla_partido, fn ($q) => $q->where('sigla_partido', $this->sigla_partido))
            ->paginate(10);

        return view('livewire.deputados-list', [
            'deputados' => $deputados,
        ])->layout('layouts.app');
    }
}
