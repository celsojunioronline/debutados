<!doctype html>
<html lang="pt-BR" data-sidenav-size="default" data-bs-theme="dark" data-menu-color="dark" data-topbar-color="dark" data-layout-mode="fluid">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Consulta de Despesas - Câmara</title>

    <!-- Fonts e Bootstrap -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Estilos do Template -->
    <link href="{{ asset('assets/css/vendor.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" id="app-style" />
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />

    <script src="{{ asset('assets/js/config.js') }}"></script>
    @vite('resources/js/app.js')
</head>
<body>
<div class="wrapper">

    <!-- Topbar -->
    <header class="app-topbar" style="margin-left: 0px !important;">
        <div class="page-container topbar-menu">
            <div class="d-flex align-items-center gap-1">
                <button class="topnav-toggle-button px-2" data-bs-toggle="collapse" data-bs-target="#topnav-menu-content">
                    <i data-lucide="menu" class="font-22"></i>
                </button>

            </div>
            <div class="d-flex align-items-center gap-1">
                <div class="topbar-item d-none d-sm-flex">
                    <button class="topbar-link" id="light-dark-mode" type="button">
                        <i data-lucide="moon" class="font-22 light-mode"></i>
                        <i data-lucide="sun" class="font-22 dark-mode"></i>
                    </button>
                </div>
            </div>
        </div>
    </header>

    <!-- Conteúdo da Página -->
    <div class="page-container">

        <!-- Título da Página -->
        <div class="card page-title-box rounded-0">
            <div class="d-flex align-items-sm-center flex-sm-row flex-column gap-2">
                <div class="flex-grow-1">
                    <h4 class="font-18 fw-semibold mb-0">De Olhos Abertos | Consulta de Despesas - Câmara</h4>
                </div>
            </div>
        </div>

        <!-- Vue mount point -->
        <div id="app">
            <router-view></router-view>
        </div>

    </div>

    <!-- Rodapé -->
    <footer class="footer">
        <div class="page-container">
            <div class="row">
                <div class="col-md-6 text-center text-md-start">
                    {{ date('Y') }} © Celso Junior
                </div>
            </div>
        </div>
    </footer>

</div>

<!-- Scripts do Template -->
<script src="{{ asset('assets/js/vendor.min.js') }}"></script>
<script src="{{ asset('assets/js/app.js') }}"></script>
<script src="{{ asset('assets/vendor/jquery-sparkline/jquery.sparkline.min.js') }}"></script>
<script src="{{ asset('assets/js/pages/profile.js') }}"></script>
</body>
</html>
