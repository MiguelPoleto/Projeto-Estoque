@extends("layout.default")
@section("title", "Login")
@section("content")

<main>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <!-- Botão para voltar à página inicial -->
                <div class="d-flex justify-content-start mb-3">
                    <a href="{{ route('home') }}" class="btn btn-light shadow-sm" style="border-radius: 50%; width: 50px; height: 50px; display: flex; justify-content: center; align-items: center;">
                        <i class="fa fa-house text-primary" style="font-size: 24px;"></i>
                    </a>
                </div>

                <!-- Exibir mensagens -->
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show shadow-lg" role="alert" style="border-radius: 12px; padding: 20px; font-size: 16px;">
                        <strong>Cadastro realizado com sucesso!</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show shadow-lg" role="alert" style="border-radius: 12px; padding: 20px; font-size: 16px;">
                        <strong>Credenciais inválidas.</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <!-- Cartão de Login -->
                <div class="card shadow-lg border-0" style="border-radius: 20px; background: linear-gradient(135deg, #4e54c8, #8f94fb); color: white;">
                    <div class="card-header text-center" style="border-radius: 20px 20px 0 0; background: rgba(255, 255, 255, 0.2);">
                        <h3>Bem-vindo de volta!</h3>
                        <p class="mb-0">Por favor, faça login para continuar</p>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('login.post') }}" method="POST">
                            @csrf

                            <!-- Campo de Email -->
                            <div class="form-group mb-4">
                                <label for="email" class="form-label">Email</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light text-dark"><i class="bi bi-envelope-fill"></i></span>
                                    <input type="email" placeholder="Digite seu email"
                                        id="email" name="email" class="form-control" required autofocus>
                                </div>
                                @if($errors->has('email'))
                                    <span class="text-danger">{{ $errors->first('email') }}</span>
                                @endif
                            </div>

                            <!-- Campo de Senha -->
                            <div class="form-group mb-4">
                                <label for="password" class="form-label">Senha</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light text-dark"><i class="bi bi-lock-fill"></i></span>
                                    <input type="password" placeholder="Digite sua senha"
                                        id="password" name="password" class="form-control" required>
                                </div>
                                @if($errors->has('password'))
                                    <span class="text-danger">{{ $errors->first('password') }}</span>
                                @endif
                            </div>

                            <!-- Botão de Enviar -->
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-light btn-lg shadow-sm text-dark" style="border-radius: 12px;">
                                    Entrar
                                </button>
                            </div>

                            <!-- Link para Registro -->
                            <div class="text-center mt-3">
                                <a href="{{ route('register') }}" class="text-light text-decoration-none">Não possui uma conta? <strong>Cadastre-se</strong></a>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Rodapé -->
                <div class="text-center mt-4">
                    <p class="text-muted">© 2025 StockMaster. Todos os direitos reservados.</p>
                </div>
            </div>
        </div>
    </div>
</main>

@endsection
