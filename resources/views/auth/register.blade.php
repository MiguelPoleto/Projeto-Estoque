@extends("layout.default")
@section("title", "Cadastro")
@section("content")

<main>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4">
                @if (session()->has("success"))
                <div class="alert alert-sucess">
                    {{ session()->get("success") }}
                </div>
                @endif
                @if (session()->has("error"))
                <div class="alert alert-sucess">
                    {{ session()->get("error") }}
                </div>
                @endif
                <div class="card">
                    <h3 class="card-header text-center">Cadastro</h3>
                    <div class="card-body">
                        <form action="{{ route("register.post") }}" method="POST">
                            @csrf
                            <div class="form-group mb-3">
                                <input type="text" placeholder="Nome Completo"
                                    id="name" name="fullname" class="form-control"
                                    required autofocus>
                                @if($errors->has('fullname'))
                                <span class="text-danger">{{ $errors->first('fullname') }}</span>
                                @endif
                            </div>
                            <div class="form-group mb-3">
                                <input type="email" placeholder="Email"
                                    id="email" name="email" class="form-control"
                                    required autofocus>
                                @if($errors->has('email'))
                                <span class="text-danger">{{ $errors->first('email') }}</span>
                                @endif
                            </div>
                            <div class="form-group mb-3">
                                <input type="tel" placeholder="Telefone"
                                    id="phoneNumber" name="phoneNumber" class="form-control"
                                    required autofocus>
                                @if($errors->has('phoneNumber'))
                                <span class="text-danger">{{ $errors->first('phoneNumber') }}</span>
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
                            <div class="form-group mb-3">
                                <input type="password" placeholder="Confirme a senha"
                                    id="passwordConfirmation" name="passwordConfirmation" class="form-control"
                                    required>
                                @if($errors->has('passwordConfirmation'))
                                <span class="text-danger">{{ $errors->first('passwordConfirmation') }}</span>
                                @endif
                            </div>
                            <div class="d-grid mx-auto">
                                <button type="submit" class="btn btn-success btn-block">Cadastrar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

@endsection