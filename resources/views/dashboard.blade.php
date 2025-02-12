@extends("layout.sidebar")
@section("title", "Painel de Controle")
@section("content")

<div class="container-fluid py-4">
    <!-- Page Header -->
    <div class="page-header mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Painel de Controle</h4>
            <div class="date-filter">
                <select class="form-select form-select-sm" id="dateRange">
                    <option value="7">Últimos 7 dias</option>
                    <option value="30">Últimos 30 dias</option>
                    <option value="90">Últimos 90 dias</option>
                    <option value="365">Este ano</option>
                </select>
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
                            <h3 class="card-title mb-0" id="total-products">--</h3>
                        </div>
                        <i class="fas fa-box card-icon text-primary"></i>
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
                            <h3 class="card-title mb-0" id="low-stock">--</h3>
                        </div>
                        <i class="fas fa-exclamation-triangle card-icon text-warning"></i>
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
                            <h3 class="card-title mb-0" id="today-movements">--</h3>
                        </div>
                        <i class="fas fa-exchange-alt card-icon text-info"></i>
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
                            <h3 class="card-title mb-0" id="total-value">--</h3>
                        </div>
                        <i class="fas fa-dollar-sign card-icon text-success"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row g-4 mb-4">
        <div class="col-md-8">
            <div class="card dashboard-card">
                <div class="card-body">
                    <h5 class="card-title mb-4">Movimentação de Estoque</h5>
                    <canvas id="stockMovementChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card dashboard-card">
                <div class="card-body">
                    <h5 class="card-title mb-4">Categorias</h5>
                    <canvas id="categoriesChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activities Table -->
    <div class="card dashboard-card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="card-title mb-0">Atividades Recentes</h5>
                <button class="btn btn-sm btn-outline-primary">
                    Ver Todas
                </button>
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
                    <tbody id="recent-activities">
                        <!-- Populated dynamically -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
<script src="{{ asset('js/dashboard.js') }}"></script>
@endpush