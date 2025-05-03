<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cadastrar Produto</title>
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
                <a href="/import" class="nav-link mb-3">Importar</a>
                
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
            <h1 class="mb-4">Cadastrar Produto</h1>
            
            <form method="POST" action="{{ route('product.store') }}" enctype="multipart/form-data">
                @csrf
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">Nome do Produto</label>
                            <input type="text" 
                                   name="name" 
                                   id="name"
                                   class="form-control"
                                   placeholder="Digite o nome do produto"
                                   required>
                        </div>

                        <div class="form-group">
                            <label for="price">Preço</label>
                            <input type="number" 
                                   name="price" 
                                   id="price"
                                   class="form-control"
                                   placeholder="Ex: 99.90"
                                   step="0.01"
                                   min="0"
                                   required>
                        </div>

                        <div class="form-group">
                            <label for="category_id">Categoria</label>
                            <select name="category_id" 
                                    id="category_id" 
                                    class="form-control"
                                    required>
                                <option value="">Selecione uma categoria</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="description">Descrição</label>
                            <textarea name="description" 
                                      id="description" 
                                      class="form-control"
                                      rows="4"
                                      required
                                      placeholder="Digite a descrição do produto">{{ old('description') }}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="image_url">Imagem do Produto</label>
                            <input type="file" 
                                   name="image_url" 
                                   id="image_url"
                                   class="form-control-file"
                                   accept="image/*">
                        </div>
                    </div>
                </div>

                <div class="form-group mt-4">
                    <button type="submit" class="btn btn-primary">Cadastrar</button>
                    <a href="/product/list" class="btn btn-secondary">Voltar</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>