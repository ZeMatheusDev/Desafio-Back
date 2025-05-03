<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Editar Categoria</title>
    <link href="{{ asset('css/categorie.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
    <div id="menuSide">
        <div class="container">
            <h2 class="mb-4"><a href="/">Menu</a></h2>
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
        <div class="container mt-4">
            <h1 class="mb-4">Editar Categoria</h1>
            
            <form method="POST" action="{{ route('categorie.update') }}">
                @csrf
                <div class="form-group">
                    <label for="name">Nome da Categoria</label>
                    <input type="text" 
                           name="name" 
                           id="name"
                           value="{{$categorie->name}}"
                           class="form-control"
                           placeholder="Digite o nome da categoria"
                           required>
                </div>
                <input type="hidden" name="id" value="{{$categorie->id}}">
                
                <button type="submit" class="btn btn-primary">Salvar</button>
                <a href="/categorie/list" class="btn btn-secondary">Voltar</a>
            </form>
        </div>
    </div>
</body>
</html>