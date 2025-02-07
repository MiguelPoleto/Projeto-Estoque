@extends("layout.sidebar")
@section("title", "Painel de Controle")
@section("content")

<body>
    <!-- Main Content -->
    <div class="container-fluid py-4">
        <!-- Page Header -->
        <div class="page-header">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Painel de Controle</h4>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-success">
                        <i class="fas fa-download me-2"></i>Exportar Relatório
                    </button>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="row g-4 mb-4">
            <div class="col-md-3">
                <div class="card stat-card dashboard-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="card-subtitle mb-2 text-muted">Total Produtos</h6>
                                <h3 class="card-title mb-0">1,234</h3>
                            </div>
                            <i class="fas fa-box card-icon"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card stat-card dashboard-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="card-subtitle mb-2 text-muted">Produtos Baixos</h6>
                                <h3 class="card-title mb-0">45</h3>
                            </div>
                            <i class="fas fa-exclamation-triangle card-icon"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card stat-card dashboard-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="card-subtitle mb-2 text-muted">Movimentações Hoje</h6>
                                <h3 class="card-title mb-0">89</h3>
                            </div>
                            <i class="fas fa-exchange-alt card-icon"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card stat-card dashboard-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="card-subtitle mb-2 text-muted">Valor Total</h6>
                                <h3 class="card-title mb-0">R$ 45K</h3>
                            </div>
                            <i class="fas fa-dollar-sign card-icon"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Row -->
        <div class="row g-4 mb-4">
            <div class="col-md-8">
                <div class="chart-container">
                    <h5 class="mb-4">Movimentação de Estoque</h5>
                    <canvas id="stockMovementChart"></canvas>
                </div>
            </div>
            <div class="col-md-4">
                <div class="chart-container">
                    <h5 class="mb-4">Categorias</h5>
                    <canvas id="categoriesChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Recent Activities -->
        <div class="card dashboard-card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="card-title mb-0">Atividades Recentes</h5>
                    <button class="btn btn-link text-success">Ver todas</button>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Produto</th>
                                <th>Tipo</th>
                                <th>Quantidade</th>
                                <th>Data</th>
                                <th>Usuário</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Produto A</td>
                                <td><span class="badge bg-success">Entrada</span></td>
                                <td>50</td>
                                <td>07/02/2025 09:45</td>
                                <td>João Silva</td>
                                <td>
                                    <button class="btn btn-link btn-sm text-success">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>Produto B</td>
                                <td><span class="badge bg-danger">Saída</span></td>
                                <td>30</td>
                                <td>07/02/2025 09:30</td>
                                <td>Maria Santos</td>
                                <td>
                                    <button class="btn btn-link btn-sm text-success">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>Produto C</td>
                                <td><span class="badge bg-success">Entrada</span></td>
                                <td>100</td>
                                <td>07/02/2025 09:15</td>
                                <td>Pedro Oliveira</td>
                                <td>
                                    <button class="btn btn-link btn-sm text-success">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
</body>

@endsection

@push('scripts')
<script src="{{ asset('js/dashboard.js') }}"></script>
@endpush