@extends("layout.default")
@section("title", "Opções")
@section("content")

<body class="d-flex flex-column bg-light vh-100">
    <!-- Top Right Icons -->
    <div class="position-fixed top-0 end-0 m-3 top-icons" style="z-index: 1050;">
        <a href="{{ route('profile') }}" class="text-decoration-none me-3">
            <i class="fas fa-user fa-2x text-dark"></i>
        </a>
        <a href="{{ route('logout') }}" class="text-decoration-none"  onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="fas fa-sign-out-alt fa-2x text-dark"></i>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </a>
    </div>
    
    <!-- Main Options Centered -->
    <div class="container text-center d-flex flex-grow-1 justify-content-center align-items-center">
        <div class="row g-4">
            <div class="col-md-4">
                <a href="{{ route('home') }}" class="text-decoration-none">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <i class="fas fa-home fa-3x mb-3"></i>
                            <h5 class="card-title">Início</h5>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-4">
                <a href="{{ route('dashboard') }}" class="text-decoration-none">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <i class="fas fa-chart-pie fa-3x mb-3"></i>
                            <h5 class="card-title">Painel</h5>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-4">
                <a href="{{ route('stock') }}" class="text-decoration-none">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <i class="fas fa-boxes fa-3x mb-3"></i>
                            <h5 class="card-title">Estoque</h5>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-4">
                <a href="{{ route('transactions') }}" class="text-decoration-none">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <i class="fas fa-shopping-cart fa-3x mb-3"></i>
                            <h5 class="card-title">Vendas</h5>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</body>

@endsection