@extends("layout.default")
@section("title", "Cadastro")
@section("content")

<style>
    :root {
        --primary-green: #2ecc71;
        --dark-green: #27ae60;
        --light-green: #2ecc71;
        --background-soft-green: #e8f5e9;
    }

    body {
        background-color: var(--background-soft-green);
    }
</style>

<main>
    <div class="container py-5 position-relative">
        <a href="{{ route('home') }}" 
           class="btn btn-light shadow-sm position-absolute" 
           style="top: 20px; right: 20px; border-radius: 50%; width: 50px; height: 50px; display: flex; justify-content: center; align-items: center;">
            <i class="fa fa-house" style="color: var(--dark-green); font-size: 20px;"></i>
        </a>

        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show shadow-lg" role="alert" style="border-radius: 12px; padding: 20px; font-size: 16px;">
                    <strong>Ocorreu um erro ao realizar o cadastro!</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                <div class="card shadow-lg" style="background-color: white; border-radius: 20px;">
                    <h3 class="card-header text-center text-white" style="background-color: var(--primary-green); border-radius: 20px 20px 0 0;">Cadastro</h3>
                    <div class="card-body">
                        <form action="{{ route('register.post') }}" method="POST" id="registerForm">
                            @csrf
                            <div class="form-group mb-3">
                                <label for="name" class="form-label">Nome Completo</label>
                                <input type="text" placeholder="Nome Completo"
                                    id="name" name="fullname" class="form-control shadow-sm"
                                    value="{{ old('fullname') }}"
                                    required autofocus>
                            </div>

                            <div class="form-group mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" placeholder="Email"
                                    id="email" name="email" class="form-control shadow-sm"
                                    value="{{ old('email') }}" required>
                                @error('email')
                                <span class="text-danger">{{ "O Email já está sendo utilizado!" }}</span>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="phone_number" class="form-label">Telefone</label>
                                <input type="tel" placeholder="Telefone (11 dígitos)"
                                    id="phone_number" name="phone_number" class="form-control shadow-sm"
                                    value="{{ old('phone_number') }}" maxlength="11" minlength="11" onkeyup="phoneFormatted(this)"
                                    required>
                                @error('phone_number')
                                <span class="text-danger">{{ "Coloque um número válido!" }}</span>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="password" class="form-label">Senha</label>
                                <input type="password" placeholder="Senha"
                                    id="password" name="password" class="form-control shadow-sm"
                                    required>
                                @error('password')
                                <span class="text-danger">{{ "É necessário ter no mínimo 6 caracteres!" }}</span>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="passwordConfirmation" class="form-label">Confirme a Senha</label>
                                <input type="password" placeholder="Confirme a senha"
                                    id="passwordConfirmation" name="passwordConfirmation" class="form-control shadow-sm"
                                    required>
                                @error('passwordConfirmation')
                                <span class="text-danger">{{ "As senhas devem ser iguais!" }}</span>
                                @enderror
                            </div>

                            <div class="d-grid mx-auto">
                                <button type="submit" class="btn btn-block shadow-sm" style="background-color: var(--primary-green); color: white;">Cadastrar</button>
                            </div>

                            <div class="text-center mt-3">
                                <a href="{{ route('login') }}" class="text-decoration-none" style="color: var(--dark-green);">Já possui uma conta? <strong>Entre.</strong></a>
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