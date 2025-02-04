<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <title>@yield("title", "Projeto-Estoque")</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @stack('styles')
</head>

<style>
    :root {
        --primary-green: #2ecc71;
        --dark-green: #27ae60;
        --light-green: #2ecc71;
        --background-soft-green: #e8f5e9;
        --text-color: #2c3e50;
        --hover-color: #27ae60;
        --transition-speed: 0.3s;
    }

    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }

    body {
        display: flex;
        min-height: 100vh;
        font-family: 'Arial', sans-serif;
        background-color: var(--background-soft-green);
        color: var(--text-color);
    }

    .sidebar {
        width: 280px;
        height: 100vh;
        background-color: white;
        box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
        display: flex;
        flex-direction: column;
        transition: width var(--transition-speed) ease;
        position: fixed;
        left: 0;
        top: 0;
        overflow: hidden;
        border-right: 2px solid var(--primary-green);
    }

    .sidebar.minimized {
        width: 80px;
    }

    .sidebar-logo {
        display: flex;
        align-items: center;
        padding: 20px;
        background-color: var(--primary-green);
        color: white;
    }

    .sidebar-logo i {
        font-size: 24px;
        margin-right: 10px;
    }

    .sidebar-logo .text {
        font-weight: bold;
        transition: opacity var(--transition-speed) ease;
    }

    .sidebar.minimized .sidebar-logo .text {
        opacity: 0;
    }

    .sidebar-content {
        flex-grow: 1;
        padding-top: 20px;
    }

    .sidebar a {
        display: flex;
        align-items: center;
        padding: 12px 20px;
        text-decoration: none;
        color: var(--text-color);
        transition: all var(--transition-speed) ease;
        position: relative;
    }

    .sidebar a i {
        margin-right: 15px;
        font-size: 20px;
        color: var(--primary-green);
        min-width: 25px;
        text-align: center;
    }

    .sidebar a .text {
        transition: opacity var(--transition-speed) ease;
    }

    .sidebar.minimized a .text {
        opacity: 0;
        width: 0;
    }

    .sidebar a:hover,
    .sidebar a.active {
        background-color: var(--background-soft-green);
        color: var(--hover-color);
    }

    .sidebar a::after {
        content: '';
        position: absolute;
        right: 0;
        top: 50%;
        transform: translateY(-50%);
        height: 70%;
        width: 4px;
        background-color: var(--primary-green);
        opacity: 0;
        transition: opacity var(--transition-speed) ease;
    }

    .sidebar a.active::after {
        opacity: 1;
    }

    .sidebar-footer {
        margin-top: auto;
        border-top: 1px solid #eee;
    }

    .sidebar-toggle {
        width: 100%;
        padding: 15px;
        background-color: var(--primary-green);
        color: white;
        border: none;
        display: flex;
        align-items: center;
        cursor: pointer;
        transition: background-color var(--transition-speed) ease;
    }

    .sidebar-toggle:hover {
        background-color: var(--dark-green);
    }

    .sidebar-toggle i {
        margin-right: 10px;
    }

    .main-content {
        margin-left: 280px;
        padding: 20px;
        width: calc(100% - 280px);
        transition: margin-left var(--transition-speed) ease, width var(--transition-speed) ease;
    }

    .sidebar.minimized~.main-content {
        margin-left: 80px;
        width: calc(100% - 80px);
    }
</style>

<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-logo">
            <i class="fas fa-cubes"></i>
            <span class="text">Projeto Estoque</span>
        </div>

        <button class="sidebar-toggle" onclick="toggleSidebar()">
            <i class="fas fa-bars"></i>
            <span class="text">Menu</span>
        </button>

        <div class="sidebar-content">
            <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}" class="active">
                <i class="fas fa-home"></i>
                <span class="text">Início</span>
            </a>
            <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="fa-solid fa-chart-simple"></i>
                <span class="text">Painel</span>
            </a>
            <a href="{{ route('stock') }}" class="{{ request()->routeIs('stock') ? 'active' : '' }}">
                <i class="fas fa-cogs"></i>
                <span class="text">Estoque</span>
            </a>
            <a href="{{ route('transactions') }}" class="{{ request()->routeIs('transactions') ? 'active' : '' }}">
                <i class="fas fa-chart-line"></i>
                <span class="text">Transações</span>
            </a>
        </div>

        <div class="sidebar-footer">
            <a href="{{ route('profile') }}" class="{{ request()->routeIs('profile') ? 'active' : '' }}">
                <i class="fa-solid fa-user"></i>
                <span class="text">Perfil</span>
            </a>
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

    <script type="module" src="{{ asset('js/app.js') }}"></script>
    @stack('scripts')

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
</body>

<script>
    function toggleSidebar() {
        const sidebar = document.querySelector('.sidebar');
        sidebar.classList.toggle('minimized');
    }
</script>

</html>