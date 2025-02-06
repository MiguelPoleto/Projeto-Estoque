@extends("layout.sidebar")
@section("title", "Transações")

<head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
</head>

@section("content")

<div class="container-fluid py-4">
    <h1 class="page-title">
        <i class="fas fa-chart-line me-2"></i>
        Análise de Transações
    </h1>

    <div class="row mb-4">
        <div class="col-md-4">
            <div class="stats-card">
                <div class="d-flex align-items-center">
                    <div class="stats-icon bg-soft-green">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <div>
                        <h3 class="stats-value" id="total-buys">R$ 0,00</h3>
                        <p class="stats-label">Total em Compras</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="stats-card">
                <div class="d-flex align-items-center">
                    <div class="stats-icon bg-soft-red">
                        <i class="fas fa-cash-register"></i>
                    </div>
                    <div>
                        <h3 class="stats-value" id="total-sells">R$ 0,00</h3>
                        <p class="stats-label">Total em Vendas</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="stats-card">
                <div class="d-flex align-items-center">
                    <div class="stats-icon bg-soft-blue">
                        <i class="fas fa-coins"></i>
                    </div>
                    <div>
                        <h3 class="stats-value" id="total-profit">R$ 0,00</h3>
                        <p class="stats-label">Lucro Final</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="chart-container">
                <div id="curve_chart"></div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/transactions.js') }}"></script>
@endpush

@push('styles')
<link href="{{ asset('css/transactions.css') }}" rel="stylesheet">
@endpush