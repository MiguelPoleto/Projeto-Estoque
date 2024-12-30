@extends("layout.default")
@section("title", "Cadastro")
@section("content")

<main>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4">
                @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show shadow-lg" role="alert" style="border-radius: 12px; padding: 20px; font-size: 16px;">
                    <strong>Ocorreu um erro ao realizar o cadastro!</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif
                <div class="card">
                    <h3 class="card-header text-center">Cadastro</h3>
                    <div class="card-body">
                        <form action="{{ route("register.post") }}" method="POST" id="registerForm">
                            @csrf
                            <div class="form-group mb-3">
                                <input type="text" placeholder="Nome Completo"
                                    id="name" name="fullname" class="form-control"
                                    value="{{ old('fullname') }}"
                                    required autofocus>
                            </div>
                            <div class="form-group mb-3">
                                <input type="email" placeholder="Email"
                                    id="email" name="email" class="form-control"
                                    value="{{ old('email') }}" required autofocus>
                                @error('email')
                                <span class="text-danger">{{ "O Email já está sendo utilizado!" }}</span>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                <input type="tel" placeholder="Telefone"
                                    id="phone_number" name="phone_number" class="form-control"
                                    value="{{ old('phone_number') }}" maxlength="11" minlength="11" onkeyup="phoneFormatted(this)"
                                    required autofocus>
                                @error('phone_number')
                                <span class="text-danger">{{ "Coloque um número válido!" }}</span>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                <input type="password" placeholder="Senha"
                                    id="password" name="password" class="form-control"
                                    required autofocus>
                                @error('password')
                                <span class="text-danger">{{ "É necessario ter no mínimo 6 caracteres!" }}</span>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                <input type="password" placeholder="Confirme a senha"
                                    id="passwordConfirmation" name="passwordConfirmation" class="form-control"
                                    required autofocus>
                                @error('passwordConfirmation')
                                <span class="text-danger">{{ "As senhas devem ser iguais!" }}</span>
                                @enderror
                            </div>
                            <div class="d-grid mx-auto">
                                <button type="submit" class="btn btn-success btn-block">Cadastrar</button>
                            </div>
                            <div>
                                <a href="{{ route("login") }}">Já possui uma conta? Entre.</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
    function phoneFormatted(input) {
        var phone = input.value.replace(/\D/g, '');
        phone = phone.replace(/(\d{2})(\d{5})(\d{4})/, '($1)$2-$3');
        input.value = phone;
    }
</script>

@endsection