<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Recuperar Senha</title>
  <link href="{{ asset('css/home.css') }}" rel="stylesheet">
  <script src="{{ asset('js/toast.js') }}"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css">
</head>
<body class="bg-dark text-white">

  <div class="container py-5">
    <h2 class="mb-4 text-center">Recuperar Senha</h2>

    @if(session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
      <div class="alert alert-danger">
        <ul class="mb-0">
          @foreach($errors->all() as $e)
            <li>{{ $e }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form action="{{ route('senha.store') }}" method="POST">
      @csrf

      <div class="form-group mb-3">
        <label for="email">E‑mail</label>
        <input type="email" name="email" id="email"
               class="form-control"
               value="{{ old('email') }}"
               placeholder="seu@exemplo.com" required autofocus>
      </div>

      <button type="submit" class="btn btn-primary w-100">Recuperar senha</button>

      <div class="mt-3 text-center">
        <a href="{{ route('home') }}" class="link-light">Voltar ao login</a>
      </div>
    </form>
  </div>

</body>
</html>
