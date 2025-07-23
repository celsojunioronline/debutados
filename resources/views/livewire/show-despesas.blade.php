@extends('layouts.app')

@section('content')
    <div>
        {{-- Cabeçalho do Deputado --}}
        <div class="row">
            <div class="col-sm-12">
                <div class="profile-user-box">
                    <div class="row">
                        <div class="col-sm-6">
                            <span class="float-start me-3">
                                <img src="{{ $deputado->url_foto }}" alt="" class="avatar-xl rounded-circle">
                            </span>
                            <div class="media-body">
                                <h4 class="mt-1 mb-1 font-18 ellipsis">{{ $deputado->nome }}</h4>
                                <p class="font-13">User Experience Specialist</p>
                                <p class="text-muted mb-0">
                                    <small>{{ $deputado->sigla_partido }}, {{ $deputado->sigla_uf }}</small>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <!--/ meta -->
            </div>
        </div>

        {{-- Informações Pessoais --}}
        <div class="row">
            <div class="col-xl-4">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title mt-0 mb-4">Personal Information</h4>
                        <div class="panel-body">
                            <p class="text-muted font-13">
                                Hye, I’m Johnathan Doe residing in this beautiful world. I create websites and mobile apps with great UX and UI design.
                            </p>
                            <hr />
                            <div class="text-left">
                                <p class="text-muted font-13"><strong>Full Name :</strong> <span class="ms-3">Johnathan Deo</span></p>
                                <p class="text-muted font-13"><strong>Mobile :</strong> <span class="ms-3">{{ $deputado->sexo }}</span></p>
                                <p class="text-muted font-13"><strong>Email :</strong> <span class="ms-3">{{ $deputado->email }}</span></p>
                                <p class="text-muted font-13"><strong>Location :</strong> <span class="ms-3">USA</span></p>
                                <p class="text-muted font-13"><strong>Languages :</strong>
                                    <span class="ms-1"><span class="flag-icon flag-icon-us me-1" title="us"></span>English</span>
                                    <span class="ms-1"><span class="flag-icon flag-icon-de me-1" title="de"></span>German</span>
                                    <span class="ms-1"><span class="flag-icon flag-icon-es me-1" title="es"></span>Spanish</span>
                                    <span class="ms-1"><span class="flag-icon flag-icon-fr me-1" title="fr"></span>French</span>
                                </p>
                            </div>

                            <ul class="social-links list-inline mt-4 mb-0">
                                <li class="list-inline-item"><a class="tooltips" href="#" data-bs-toggle="tooltip" title="Facebook"><i class="fab fa-facebook-f"></i></a></li>
                                <li class="list-inline-item"><a class="tooltips" href="#" data-bs-toggle="tooltip" title="Twitter"><i class="fab fa-twitter"></i></a></li>
                                <li class="list-inline-item"><a class="tooltips" href="#" data-bs-toggle="tooltip" title="Skype"><i class="fab fa-skype"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Cards (Placeholder, mantenho intacto) --}}
            <div class="col-xl-8">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="card widget-box-four">
                            <div class="card-body">
                                <h4 class="mt-0 font-16 mb-1 fw-semibold">Total Revenue</h4>
                                <p class="fs-secondary text-muted">Jan - Apr 2017</p>
                                <h3 class="mb-0 mt-4 fw-semibold">R$ 1,28,5960</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card widget-box-four">
                            <div class="card-body">
                                <h4 class="mt-0 font-16 mb-1 fw-semibold">Total Unique Visitors</h4>
                                <p class="fs-secondary text-muted">Jan - Apr 2017</p>
                                <h3 class="mb-0 mt-4 fw-semibold">$ 1,28,5960</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card widget-box-four">
                            <div class="card-body">
                                <h4 class="mt-0 font-16 mb-1 fw-semibold">Number of Transactions</h4>
                                <p class="fs-secondary text-muted">Jan - Apr 2017</p>
                                <h3 class="mb-0 mt-4 fw-semibold">$ 1,28,5960</h3>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Campo de Busca Livewire --}}
                <div class="row mb-3">
                    <div class="col-md-6">
                        <input type="text"
                               wire:model.debounce.500ms="search"
                               class="form-control"
                               placeholder="Buscar por tipo ou fornecedor...">
                    </div>
                </div>

                {{-- Tabela de Despesas --}}
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table mb-0">
                                <thead>
                                <tr>
                                    <th>Data</th>
                                    <th>Tipo</th>
                                    <th>Fornecedor</th>
                                    <th>Valor</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($despesas as $despesa)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($despesa->data_documento)->format('d/m/Y') }}</td>
                                        <td>{{ $despesa->tipo_despesa }}</td>
                                        <td>{{ $despesa->nome_fornecedor }}</td>
                                        <td>R$ {{ number_format($despesa->valor_documento, 2, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                        {{-- Paginação Livewire --}}
                        <div class="d-flex justify-content-center mt-4">
                            {{ $despesas->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
