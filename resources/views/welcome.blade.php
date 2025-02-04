@extends("layout.default")
@section("title", "Início")
@section("content")

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('home') }}">
                <i class="bi bi-box-seam me-2"></i>StockMaster
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    @if (Auth::check())
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('options') }}">Sistema</a>
                    </li>
                    @endif
                    @if (!Auth::check())
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Login</a>
                    </li>
                    @endif
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('about') }}">Sobre</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('contact') }}">Contato</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <main>
        <div class="hero-section">
            <div class="container">
                @if (Auth::check())
                <h1>Olá, {{ explode(' ', Auth::user()->name)[0] }}</h1>
                <p class="lead mb-4">Gerencie seu estoque com eficiência e inteligência.</p>
                <div class="d-flex justify-content-center gap-3">
                    <a href="{{ route('options') }}" class="btn btn-primary btn-lg">
                        <i class="bi bi-box-seam me-2"></i>Acessar Sistema
                    </a>
                    <a href="{{ route('about') }}" class="btn btn-outline-light btn-lg">
                        <i class="bi bi-info-circle me-2"></i>Saiba Mais
                    </a>
                </div>
                @else
                <h1>Bem-vindo ao StockMaster</h1>
                <p class="lead mb-4">Gerencie seu estoque com eficiência e inteligência.</p>
                <div class="d-flex justify-content-center gap-3">
                    <a href="{{ route('login') }}" class="btn btn-primary btn-lg">
                        <i class="bi bi-door-open me-2"></i>Acessar Sistema
                    </a>
                    <a href="{{ route('about') }}" class="btn btn-outline-light btn-lg">
                        <i class="bi bi-info-circle me-2"></i>Saiba Mais
                    </a>
                </div>
                @endif
            </div>
        </div>

        <!-- Features Section -->
        <div class="features-section">
            <div class="container">
                <div class="row text-center">
                    <div class="col-md-4 mb-4">
                        <div class="feature-card">
                            <i class="bi bi-box-seam display-4 text-success mb-3"></i>
                            <h3 class="mb-3">Controle de Itens</h3>
                            <p>Gerencie seus produtos com um sistema intuitivo e eficiente.</p>
                        </div>
                    </div>
                    <div class="col-md-4 mb-4">
                        <div class="feature-card">
                            <i class="bi bi-graph-up-arrow display-4 text-success mb-3"></i>
                            <h3 class="mb-3">Relatórios Detalhados</h3>
                            <p>Insights precisos para tomada de decisões estratégicas.</p>
                        </div>
                    </div>
                    <div class="col-md-4 mb-4">
                        <div class="feature-card">
                            <i class="bi bi-shield-lock display-4 text-success mb-3"></i>
                            <h3 class="mb-3">Segurança</h3>
                            <p>Proteção avançada com autenticação e criptografia robustas.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer>
        <div class="container">
            <p class="mb-0">
                &copy; 2025 StockMaster. Todos os direitos reservados.
                <br class="d-md-none">
                <span class="d-none d-md-inline">|</span> 
                Desenvolvido para gestão inteligente
            </p>
        </div>
    </footer>
</body>

@endsection

@push('styles')
<link href="{{ asset('css/welcome.css') }}" rel="stylesheet">
@endpush