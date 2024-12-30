@extends("layout.default")
@section("title", "Contato")
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
                        <a class="nav-link" href="{{ route("about") }}">Sobre</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Contact Section -->
    <main>
        <div class="container my-5">
            <h1 class="text-center mb-4">Entre em Contato</h1>
            <p class="text-center text-muted">Aqui estão os meios pelos quais você pode entrar em contato conosco.</p>

            <div class="row mt-4">
                <!-- Email Contact -->
                <div class="col-md-4 text-center">
                    <i class="bi bi-envelope display-4 text-primary"></i>
                    <h4 class="mt-2">Email</h4>
                    <p>miguelpoleto5@gmail.com</p>
                </div>
                <!-- WhatsApp -->
                <div class="col-md-4 text-center">
                    <i class="bi bi-whatsapp display-4 text-success"></i>
                    <h4 class="mt-2">WhatsApp</h4>
                    <p>(28) 99944-5738</p>
                </div>
                <!-- Address -->
                <div class="col-md-4 text-center">
                    <i class="bi bi-geo-alt display-4 text-primary"></i>
                    <h4 class="mt-2">Endereço</h4>
                    <p>Rua xxx, xxx, Cachoeiro de Itapemirim, ES</p>
                </div>
            </div>
            
            <div class="row mt-4">
                <!-- GitHub -->
                <div class="col-md-4 text-center">
                    <i class="bi bi-telephone display-4 text-primary"></i>
                    <h4 class="mt-2">GitHub</h4>
                    <p><a href="https://github.com/MiguelPoleto">MiguelPoleto</a></p>
                </div>
                <!-- LinkedIn -->
                <div class="col-md-4 text-center">
                    <i class="bi bi-facebook display-4 text-primary"></i>
                    <h4 class="mt-2">LinkedIn</h4>
                    <p><a href="https://www.linkedin.com/in/miguelpoleto" class="text-decoration-none" target="_blank">miguelpoleto</a></p>
                </div>
                <!-- Instagram -->
                <div class="col-md-4 text-center">
                    <i class="bi bi-instagram display-4 text-danger"></i>
                    <h4 class="mt-2">Instagram</h4>
                    <p><a href="https://www.instagram.com/miguelsantuchi/" class="text-decoration-none" target="_blank">@miguelsantuchi</a></p>
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