@extends("layout.default")
@section("title", "Inicio")
@section("content")

<style>
    body {
        display: flex;
        flex-direction: column;
        min-height: 100vh;
        margin: 0;
    }

    main {
        flex: 1;
    }

    footer {
        background-color: #007bff;
        color: white;
        text-align: center;
        padding: 1rem 0;
    }
</style>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route("home") }}">StockMaster</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route("login") }}">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route("about") }}">Sobre</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route("contact") }}">Contato</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <main>
        <div class="container-fluid bg-light text-dark py-5 text-center">
            <h1>Bem-vindo ao StockMaster</h1>
            <p class="lead">Gerencie seu estoque com eficiência e simplicidade.</p>
            <a href="#" class="btn btn-primary btn-lg">Acessar Sistema</a>
            <a href="{{ route("about") }}" class="btn btn-outline-primary btn-lg">Saiba Mais</a>
        </div>

        <!-- Features Section -->
        <div class="container my-5">
            <div class="row text-center">
                <div class="col-md-4">
                    <i class="bi bi-box-seam display-4 text-primary"></i>
                    <h3>Controle de Itens</h3>
                    <p>Adicione, remova e atualize seus itens com facilidade.</p>
                </div>
                <div class="col-md-4">
                    <i class="bi bi-graph-up-arrow display-4 text-primary"></i>
                    <h3>Relatórios Detalhados</h3>
                    <p>Visualize relatórios para tomar decisões informadas.</p>
                </div>
                <div class="col-md-4">
                    <i class="bi bi-shield-lock display-4 text-primary"></i>
                    <h3>Segurança</h3>
                    <p>Seus dados protegidos com autenticação e criptografia.</p>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer>
        <p>&copy; 2025 StockMaster. Todos os direitos reservados.</p>
    </footer>
</body>

@endsection