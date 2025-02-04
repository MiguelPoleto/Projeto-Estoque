@extends("layout.sidebar")
@section("title", "Perfil")
@section("content")

<div class="container mt-5">
    @if (session('success'))
    <div id="success-alert" class="alert alert-success alert-dismissible fade show shadow-lg" role="alert" style="border-radius: 12px; padding: 20px; font-size: 16px; position: fixed; top: 20px; right: 20px; z-index: 1050;">
        <strong>Perfil atualizado!</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    <div class="card">
        <div class="card-header">
            <h3><i class="fas fa-user-edit"></i> Atualizar Perfil</h3>
        </div>
        <div class="card-body">
            <form action="{{ route("profile.update") }}" method="POST" enctype="multipart/form-data">
                @csrf
                <!-- Nome -->
                <div class="mb-3">
                    <label for="name" class="form-label"><i class="fas fa-user"></i> Nome</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Digite seu nome" value="{{ $user->name }}" required>
                </div>

                <!-- Email -->
                <div class="mb-3">
                    <label for="email" class="form-label"><i class="fas fa-envelope"></i> Email</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Digite seu email" value="{{ $user->email }}" required>
                </div>

                <!-- Telefone -->
                <div class="mb-3">
                    <label for="phone_number" class="form-label"><i class="fas fa-phone"></i> Telefone</label>
                    <input type="tel" class="form-control" id="phone_number" name="phone_number" 
                    placeholder="Digite seu número de telefone" value="{{ $user->phone_number }}"
                    maxlength="14" minlength="11" onkeyup="phoneFormatted(this)">
                </div>

                <!-- Foto de Perfil -->
                <div class="mb-3">
                    <label for="profile_picture" class="form-label"><i class="fas fa-camera"></i> Foto de Perfil</label>
                    <input type="file" class="form-control" id="profile_picture" name="profile_picture" value="{{ $user->profile_picture }}">
                </div>

                <!-- Endereço -->
                <div class="mb-3">
                    <label for="endereco" class="form-label"><i class="fas fa-map-marker-alt"></i> Endereço</label>
                    <div class="row">
                        <div class="col-md-6">
                            <input type="text" class="form-control mb-2" id="city" name="city" placeholder="Cidade" value="{{ $user->city }}">
                        </div>
                        <div class="col-md-4">
                            <input type="text" class="form-control mb-2" id="street" name="street" placeholder="Rua" value="{{ $user->street }}">
                        </div>
                        <div class="col-md-2">
                            <input type="text" class="form-control mb-2" id="house_number" name="house_number" placeholder="Número" value="{{ $user->house_number }}">
                        </div>
                    </div>
                </div>

                <!-- Botões -->
                <div class="text-center">
                    <button type="submit" class="btn btn-success me-2"><i class="fas fa-save"></i> Salvar</button>
                    <button type="reset" class="btn btn-secondary"><i class="fas fa-undo"></i> Resetar</button>
                </div>
            </form>
        </div>
    </div>
</div>



<script>
    document.addEventListener('DOMContentLoaded', function() {
        const alertBox = document.getElementById('success-alert');
        if (alertBox) {
            setTimeout(() => {
                alertBox.style.opacity = '0';
                setTimeout(() => alertBox.remove(), 500);
            }, 3000);
        }
    });


    function phoneFormatted(input) {
        var phone = input.value.replace(/\D/g, '');
        phone = phone.replace(/(\d{2})(\d{5})(\d{4})/, '($1)$2-$3');
        input.value = phone;
    }
</script>

@endsection

@push('styles')
<link href="{{ asset('css/profile.css') }}" rel="stylesheet">
@endpush