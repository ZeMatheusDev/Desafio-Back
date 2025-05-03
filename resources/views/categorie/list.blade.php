<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Categorias</title>
    <link href="{{ asset('css/categorie.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
    @if(session('success'))
        <div style="margin-left: 1600px; display:flex; width: 250px">
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
        <div class="container mt-4">
            <div class="justify-content-between mb-4">
                <h1>Categorias</h1>
            </div>

            <form method="POST" action="{{ route('categorieP.list') }}" class="mb-4">
                @csrf
                <div class="form-group">
                    <input type="text" 
                           name="name" 
                           class="form-control" 
                           placeholder="Filtrar por nome"
                           value="{{ request()->input('name') }}">
                </div>
                <button type="submit" class="btn btn-secondary">Filtrar</button>
                <a href="{{ route('categorie.list') }}" class="btn btn-light">Limpar</a>
                <a href="/categorie/create" class="btn btn-primary">Cadastrar</a>
            </form>

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($categories as $category)
                    <tr>
                        <td>{{ $category->id }}</td>
                        <td>{{ $category->name }}</td>
                        <td>
                            <a href="/categorie/edit/{{$category->id}}" class="btn btn-sm btn-warning">Editar</a>
                            <form action="{{route('categorie.delete')}}" method="POST" style="display: inline-block;">
                                @csrf
                                <input type="hidden" name="id" value='{{$category->id}}'>
                                <button type="submit" class="btn btn-sm btn-danger">Deletar</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>