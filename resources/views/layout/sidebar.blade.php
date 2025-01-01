<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <title>@yield("title", "Projeto-Estoque")</title>
</head>

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

    /* Profile button */
    .profile {
        margin-top: auto;
        width: 100%;
        text-align: center;
    }

    .profile a {
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
            <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="fa-solid fa-chart-simple"></i>
                <span class="text">Painel</span>
            </a>
            <a href="{{ route('stock') }}" class="{{ request()->routeIs('stock') ? 'active' : '' }}">
                <i class="fas fa-cogs"></i>
                <span class="text">Estoque</span>
            </a>
            <a href="{{ route('sales') }}" class="{{ request()->routeIs('sales') ? 'active' : '' }}">
                <i class="fas fa-chart-line"></i>
                <span class="text">Vendas</span>
            </a>
        </div>
        <div class="profile">
            <a href="{{ route('profile') }}" class="{{ request()->routeIs('profile') ? 'active' : '' }}">
            <i class="fa-solid fa-user"></i>
            <span class="text">Perfil</span>
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


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
</body>

<script>
    function toggleSidebar() {
        const sidebar = document.querySelector('.sidebar');
        sidebar.classList.toggle('minimized');
    }
</script>

</html>