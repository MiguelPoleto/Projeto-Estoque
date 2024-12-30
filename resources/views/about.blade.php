@extends("layout.default")
@section("title", "Sobre")
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
                        <a class="nav-link active" href="{{ route("home") }}">Início</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route("contact") }}">Contato</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- About Section -->
    <main>
        <div class="container my-5">
            <h1 class="text-center mb-4">Sobre o Projeto</h1>
            <p class="text-muted text-center">Conheça mais sobre nosso sistema de gestão de estoque e como ele pode transformar a sua operação.</p>

            <div class="row mt-5">
                <div class="col-md-6">
                    <h3 class="mb-3">O que é o Projeto?</h3>
                    <p>
                        Este projeto é uma solução desenvolvida para facilitar o gerenciamento de estoques, ajudando empresas de todos os tamanhos a monitorar, organizar e otimizar seus inventários. Ele foi criado com foco na simplicidade, eficiência e acessibilidade, garantindo que os usuários tenham total controle sobre suas operações.
                    </p>
                    <p>
                        Nosso objetivo é ajudar empresas a reduzir custos, melhorar a eficiência operacional e evitar problemas como falta ou excesso de estoque.
                    </p>
                </div>
                <div class="col-md-6">
                    <img src="https://via.placeholder.com/500x300" class="img-fluid rounded" alt="Imagem sobre estoque">
                </div>
            </div>

            <div class="row mt-5">
                <div class="col-md-6">
                    <img src="https://via.placeholder.com/500x300" class="img-fluid rounded" alt="Equipe">
                </div>
                <div class="col-md-6">
                    <h3 class="mb-3">Funcionalidades</h3>
                    <ul>
                        <li>Monitoramento de itens em tempo real.</li>
                        <li>Relatórios detalhados sobre movimentação de estoque.</li>
                        <li>Alertas para evitar faltas ou excessos.</li>
                        <li>Interface intuitiva e fácil de usar.</li>
                        <li>Suporte para integração com sistemas existentes.</li>
                    </ul>
                </div>
            </div>

        </div>
    </main>

    <!-- Footer -->
    <footer>
        &copy; 2025 StockMaster. Todos os direitos reservados.
    </footer>
</body>

@endsection