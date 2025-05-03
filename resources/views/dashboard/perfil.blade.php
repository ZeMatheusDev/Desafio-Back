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
        <div class="container mt-4">
            <h1 class="mb-4">Editar Perfil</h1>
            
            <form method="POST" action="{{ route('perfil.update') }}">
                @csrf

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">Nome Completo</label>
                            <input type="text" 
                                   name="name" 
                                   id="name"
                                   class="form-control"
                                   value="{{$user->name}}"
                                   required>
                        </div>

                        <div class="form-group">
                            <label for="email">E-mail</label>
                            <input type="email" 
                                   name="email" 
                                   id="email"
                                   class="form-control"
                                   value="{{$user->email}}"
                                   required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="phone">Telefone</label>
                            <input type="tel" 
                                   name="phone" 
                                   id="phone"
                                   class="form-control"
                                   value="{{$user->phone}}"
                                   pattern="[0-9]{11}"
                                   title="Digite o DDD + número (ex: 82999999999)">
                        </div>

                        <div class="form-group">
                            <label for="password">Nova Senha (opcional)</label>
                            <input type="password" 
                                   name="password" 
                                   id="password"
                                   class="form-control"
                                   placeholder="Deixe em branco para manter a senha atual">
                        </div>
                    </div>
                </div>

                <div class="form-group mt-4">
                    <button type="submit" class="btn btn-primary">Salvar Alterações</button>
                    <a href="/dashboard" class="btn btn-secondary">Voltar</a>
                </div>
            </form>
        </div>
    </div>


</body>
</html>