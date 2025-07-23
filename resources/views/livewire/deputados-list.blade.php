@extends('layouts.app')

@section('content')
    <div>
        <input type="text" wire:model.live.debounce.500ms="search" placeholder="Buscar nome..." class="form-control mb-2">
        <div class="row">
                <div class="col-6">
                    <select wire:model="sigla_uf" class="form-control">
                        <option value="">UF</option>
                        @foreach($ufs as $uf)
                            <option value="{{ $uf }}">{{ $uf }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-6">
                    <select wire:model="sigla_partido" class="form-control">
                        <option value="">Partido</option>
                        @foreach($partidos as $partido)
                            <option value="{{ $partido }}">{{ $partido }}</option>
                        @endforeach
                    </select>
                </div>
               <p></p>
            @foreach($deputados as $dep)
            <div class="col-lg-4" ">
                <div class="card">
                    <div class="card-body">
                        <div class="member-card-alt">
                            <div class="avatar-xxl member-thumb mb-2 float-start">
                                <img src="{{ $dep->url_foto }}" class="img-thumbnail" alt="{{ $dep->nome }}">
                                <i class="mdi mdi-star-circle member-star text-success" title="verified user"></i>
                            </div>
                            <div class="member-card-alt-info">
                                <h4 class="mb-1 mt-0 fw-semibold">{{ $dep->nome }}</h4>
                                <p class="text-muted">{{ $dep->sigla_partido }} <span> | </span> <span> {{ $dep->sigla_uf }} </span></p>
                                <p class="text-muted font-13">
                                    Hi I'm Johnathn Deo,has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type.
                                </p>
                                <a href="{{ route('deputados.despesas', $dep->id) }}" class="btn btn-sm btn-primary">
                                    Ver Despesas
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="d-flex justify-content-center mt-4">
            {{ $deputados->links() }}
        </div>
    </div>

@endsection
