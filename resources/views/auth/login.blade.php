@extends("layout.default")
@section("title", "Login")
@section("content")

<main>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4">
                @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show shadow-lg" role="alert" style="border-radius: 12px; padding: 20px; font-size: 16px;">
                    <strong>Cadastro realizado com sucesso!</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif
                <div class="card">
                    <h3 class="card-header text-center">Login</h3>
                    <div class="card-body">
                        <form action="{{ route("login.post") }}" method="POST">
                            @csrf
                            <div class="form-group mb-3">
                                <input type="text" placeholder="Email"
                                    id="email" name="email" class="form-control"
                                    required autofocus>
                                @if($errors->has('email'))
                                <span class="text-danger">{{ $errors->first('email') }}</span>
                                @endif
                            </div>
                            <div class="form-group mb-3">
                                <input type="password" placeholder="Senha"
                                    id="password" name="password" class="form-control"
                                    required>
                                @if($errors->has('password'))
                                <span class="text-danger">{{ $errors->first('password') }}</span>
                                @endif
                            </div>
                            <div class="d-grid mx-auto">
                                <button type="submit" class="btn btn-dark btn-block">Logar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

@endsection