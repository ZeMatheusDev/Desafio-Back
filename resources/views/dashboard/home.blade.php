<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dashboard</title>
    <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="{{ asset('js/toast.js') }}"></script>
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

    <div id="menuSide">
        <div class="container">
            <h2 class="mb-4"><a href="/dashboard">Menu</a></h2>
            <nav class="nav flex-column">
                <a href="/product/list" class="nav-link mb-3">
                    Produto
                </a>

                <a href="/categorie/list" class="nav-link mb-3">
                    Categoria
                </a>
                
                <a href="/perfil" class="nav-link">
                    Perfil
                </a>
            </nav>
            <form action="{{ route('logout') }}" method="POST" class="w-100">
                @csrf
                <button id="exit" type="submit" class="btn btn-link text-decoration-none w-100 text-left p-0 mb-3">
                    Sair
                </button>
            </form>
        </div>
    </div>

    <div class="main-content">
        <div class="container mt-5">
            <h1>Bem-vindo ao Dashboard</h1>
            <p>Selecione uma opção no menu lateral para começar</p>
        </div>
    </div>


</body>
</html>