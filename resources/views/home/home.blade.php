<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Inicio</title>
    <link href="{{ asset('css/home.css') }}" rel="stylesheet">
    <script src="{{ asset('js/toast.js') }}"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
    @if(session('success'))
        <div style="margin: 0 auto; display:flex; width: 250px">
            <div role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header bg-success text-white">
                    <strong class="me-auto">Sucesso!</strong>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
                </div>
                <div class="toast-body">
                    {{ session('success') }}
                </div>
            </div>
        </div>
    @endif
    <div id="menuSide" class="text-white">
        <div class="container">
            <h2 class="mb-4">Login</h2>
            <form action="{{route('login')}}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input 
                        type="email" 
                        class="form-control"
                        name="email"
                        id="email"
                        placeholder="exemplo@email.com"
                        required>
                </div>

                <div class="mb-4">
                    <label for="senha" class="form-label">Senha</label>
                    <input 
                        type="password" 
                        class="form-control"
                        name="senha"
                        id="senha"
                        placeholder="Digite sua senha"
                        required>
                </div>

                <button type="submit" class="btn btn-primary w-100 mb-3">
                    Entrar
                </button>

                <div class="text-center">
                    <a href="/createAccount" class="link-light text-decoration-none">
                        Criar nova conta
                    </a>  
                    <br>
                    <a href="{{ route('senha') }}" class="link-light text-decoration-none mt-2 d-block">
                        Esqueci minha senha
                    </a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>