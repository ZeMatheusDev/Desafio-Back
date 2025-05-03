<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Conta</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/create.css') }}" rel="stylesheet">
    <script src="{{ asset('js/toast.js') }}"></script>
</head>
<body>
    <div class="container">
        <div class="custom-card card">
            <div class="card-header bg-primary text-white">
                <h3 class="mb-0">Criar Conta</h3>
            </div>
            
            <div class="card-body">
                <form method="POST" action="{{route('account.store')}}">
                    @csrf
                    
                    <div class="mb-3">
                        <label class="form-label">Nome Completo</label>
                        <input type="text" 
                               name="name" 
                               class="form-control" 
                               maxlength="255"
                               required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">E-mail</label>
                        <input type="email" 
                               name="email" 
                               class="form-control" 
                               maxlength="255"
                               required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Telefone</label>
                        <input type="tel" 
                               name="phone" 
                               class="form-control" 
                               maxlength="20">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Senha</label>
                        <input type="password" 
                               name="password" 
                               class="form-control" 
                               maxlength="50"
                               required>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 py-2">
                        Criar Conta
                    </button>
                </form>
            </div>

            <div class="card-footer text-center">
                Já tem conta? <a href="/" class="text-primary">Faça Login</a>
            </div>
        </div>
    </div>
        @if($errors->any())
            <div class="toast-container position-fixed top-0 end-0 p-3" style="width: 350px">
                <div class="alert" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="toast-header bg-danger text-white">
                        <strong class="me-auto">Erro!</strong>
                    </div>
                    <div class="toast-body">
                        @foreach ($errors->all() as $error)
                            {{ $error }}<br>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
</body>
</html>