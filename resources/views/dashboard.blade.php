@extends("layout.default")
@section("title", "Painel")
@section("content")

<style>
    body {
        display: flex;
        min-height: 100vh;
        margin: 0;
    }

    /* Sidebar Style */
    .sidebar {
        position: fixed;
        top: 0;
        left: 0;
        width: 250px;
        height: 100%;
        background-color: #343a40;
        display: flex;
        flex-direction: column;
        padding-top: 20px;
        transition: width 0.3s ease;
        overflow: hidden;
    }

    .sidebar.minimized {
        width: 60px;
    }

    .sidebar-content {
        display: flex;
        flex-direction: column;
        flex: 1;
        justify-content: center;
        /* Centraliza os itens verticalmente */
        align-items: center;
        /* Alinha os itens horizontalmente */
    }

    .sidebar a {
        padding: 10px 15px;
        text-decoration: none;
        font-size: 18px;
        color: white;
        display: flex;
        align-items: center;
        transition: 0.3s;
        overflow: hidden;
        width: 100%;
    }

    .sidebar a .text {
        margin-left: 10px;
        white-space: nowrap;
    }

    .sidebar.minimized a .text {
        display: none;
    }

    .sidebar a:hover {
        background-color: #007bff;
    }

    .sidebar .active {
        background-color: #007bff;
    }

    .sidebar i {
        font-size: 20px;
    }

    /* Logout button */
    .logout {
        margin-top: auto;
        padding-bottom: 20px;
        width: 100%;
        text-align: center;
    }

    .logout a {
        width: 100%;
    }

    /* Main content */
    .main-content {
        margin-left: 250px;
        padding: 20px;
        flex: 1;
        transition: margin-left 0.3s ease;
    }

    .sidebar.minimized~.main-content {
        margin-left: 60px;
    }

    /* Toggle Button */
    .sidebar-toggle {
        display: block;
        background-color: #007bff;
        color: white;
        border: none;
        padding: 10px;
        font-size: 18px;
        width: 100%;
        text-align: left;
        cursor: pointer;
    }

    .sidebar-toggle i {
        margin-right: 10px;
    }

    .sidebar-toggle .text {
        white-space: nowrap;
    }

    .sidebar.minimized .sidebar-toggle .text {
        display: none;
    }
</style>

<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <button class="sidebar-toggle" onclick="toggleSidebar()">
            <i class="fas fa-bars"></i>
            <span class="text">Menu</span>
        </button>
        <div class="sidebar-content">
            <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">
                <i class="fas fa-home"></i>
                <span class="text">Início</span>
            </a>
            <a href="#" class="{{ request()->routeIs('stock') ? 'active' : '' }}">
                <i class="fas fa-cogs"></i>
                <span class="text">Estoque</span>
            </a>
            <a href="#" class="{{ request()->routeIs('sales') ? 'active' : '' }}">
                <i class="fas fa-chart-line"></i>
                <span class="text">Vendas</span>
            </a>
        </div>
        <div class="logout">
            <a href="{{ route('logout') }}" class="text-danger" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fas fa-sign-out-alt"></i>
                <span class="text">Sair</span>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        @yield('content')
    </div>

</body>

<script>
    function toggleSidebar() {
        const sidebar = document.querySelector('.sidebar');
        sidebar.classList.toggle('minimized');
    }
</script>

@endsection 