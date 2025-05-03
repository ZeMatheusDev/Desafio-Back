<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Importar Produtos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/import.css') }}" rel="stylesheet">
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
            <a href="/product/list" class="nav-link mb-3">Produto</a>
            <a href="/categorie/list" class="nav-link mb-3">Categoria</a>
            <a href="/import" class="nav-link mb-3">Importar</a>
            <a href="/perfil" class="nav-link">Perfil</a>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button id="exit" type="submit" class="btn btn-link text-decoration-none text-left p-0 mb-3">
                Sair
                </button>
            </form>
        </nav>

    </div>
</div>

<div class="main-content">
    <div class="container">
        <h1 class="mb-4">Importar Produtos</h1>

        <div class="mb-4">
            <input type="text" id="searchInput" class="form-control form-control-lg" 
                   placeholder="Pesquisar produtos...">
                <form action="{{ route('importAll.store') }}" method="POST" class="mt-3">
                    @csrf
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-download"></i> Importar Todos os Produtos
                    </button>
                </form>
        </div>

        <div class="row row-cols-1 row-cols-md-3 g-4" id="productList">
            @foreach($products as $product)
            <div class="col product-card">
                <div class="card h-100">
                    <img src="{{ $product['image'] }}" class="card-img-top" 
                         style="height: 200px; object-fit: contain;" 
                         alt="{{ $product['title'] }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $product['title'] }}</h5>
                        <p class="card-text text-muted small">
                            {{ \Illuminate\Support\Str::limit($product['description'], 100) }}
                        </p>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="badge bg-primary">{{ $product['category'] }}</span>
                            <span class="h5">R$ {{ number_format($product['price'], 2, ',', '.') }}</span>
                        </div>
                        <form action="{{route('import.store')}}" method="POST">
                            @csrf
                            <input type="hidden" name="id" value="{{$product['id']}}">
                            <button class="btn btn-success w-100 import-btn" 
                                    data-product="{{ htmlspecialchars(json_encode($product), ENT_QUOTES, 'UTF-8') }}">
                                Importar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<div class="toast-container">
    <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
            <strong class="me-auto">Notificação</strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast"></button>
        </div>
        <div class="toast-body"></div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const products = document.querySelectorAll('.product-card');

    searchInput.addEventListener('input', function() {
        const term = this.value.toLowerCase();
        
        products.forEach(product => {
            const text = product.textContent.toLowerCase();
            product.style.display = text.includes(term) ? 'block' : 'none';
        });
    });

    document.querySelectorAll('.import-btn').forEach(button => {
        button.addEventListener('click', async function() {
            const product = JSON.parse(this.dataset.product);
            const btn = this;
            
            btn.disabled = true;
            btn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status"></span> Importando...';

            try {
                const response = await fetch('/import-product', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify(product)
                });

                const data = await response.json();
                showToast(data.success ? 'success' : 'error', data.message);

                if(data.success) {
                    btn.innerHTML = '<i class="bi bi-check2"></i> Importado!';
                    btn.classList.remove('btn-success');
                    btn.classList.add('btn-secondary');
                } else {
                    btn.disabled = false;
                    btn.innerHTML = 'Tentar Novamente';
                }
            } catch (error) {
                showToast('error', 'Erro na conexão');
                btn.disabled = false;
                btn.innerHTML = 'Importar';
            }
        });
    });

    function showToast(type, message) {
        const toastEl = document.getElementById('liveToast');
        const toastBody = toastEl.querySelector('.toast-body');
        const toastHeader = toastEl.querySelector('.toast-header');

        toastHeader.className = 'toast-header';
        toastBody.className = 'toast-body';

        toastHeader.classList.add('text-white', 'bg-' + type);
        toastBody.textContent = message;
        
        const toast = new bootstrap.Toast(toastEl);
        toast.show();

        setTimeout(() => toast.hide(), 5000);
    }
});
</script>

</body>
</html>