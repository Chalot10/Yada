<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro | Yada Key Consulting and Services</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Fonte -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Ícones -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        * { font-family: 'Inter', sans-serif; }

        .brand-primary { background-color: #03588C; }
        .brand-secondary { background-color: #024059; }
        .brand-light { background-color: #F2F2F2; }
        .brand-accent1 { background-color: #F2B84B; }
        .brand-accent2 { background-color: #D97B29; }

        .text-brand-primary { color: #03588C; }
        .text-brand-secondary { color: #024059; }

        .btn-primary {
            background-color: #F2B84B;
            color: #024059;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #D97B29;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(217, 123, 41, 0.3);
        }
    </style>
</head>

<body class="bg-brand-light min-h-screen flex items-center justify-center px-4">

    <!-- Card -->
    <div class="w-full max-w-lg bg-white rounded-2xl shadow-2xl p-6 sm:p-8 lg:p-10">

        <!-- Cabeçalho -->
        <div class="text-center mb-8">
            <h2 class="text-3xl font-bold text-brand-secondary">Criar Conta</h2>
                
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $erro)
                            <li>{{ $erro }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

        </div>

        <!-- Formulário -->
        <form method="POST" action="{{ route('register.store') }}" class="space-y-5">
            @csrf

            <!-- Nome -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    <i class="fas fa-user text-brand-primary mr-1"></i> Nome Completo
                </label>
                <input
                    type="text"
                    name="name"
                    required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg
                           focus:outline-none focus:ring-2 focus:ring-brand-primary focus:border-transparent"
                    placeholder="Ex: Francisco Bento Novela"
                >
            </div>

            <!-- Email -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    <i class="fas fa-envelope text-brand-primary mr-1"></i> Email
                </label>
                <input
                    type="email"
                    name="email"
                    required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg
                           focus:outline-none focus:ring-2 focus:ring-brand-primary focus:border-transparent"
                    placeholder="exemplo@email.com"
                >
            </div>

            <!-- Senha -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    <i class="fas fa-lock text-brand-primary mr-1"></i> Senha
                </label>
                <input
                    type="password"
                    name="password"
                    required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg
                           focus:outline-none focus:ring-2 focus:ring-brand-primary focus:border-transparent"
                    placeholder="********"
                >
            </div>

            <!-- Confirmar Senha -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    <i class="fas fa-lock text-brand-primary mr-1"></i> Confirmar Senha
                </label>
                <input
                    type="password"
                    name="password_confirmation"
                    required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg
                           focus:outline-none focus:ring-2 focus:ring-brand-primary focus:border-transparent"
                    placeholder="********"
                >
            </div>

            <!-- Botão -->
            <button
                type="submit"
                class="btn-primary w-full py-3 rounded-lg font-semibold text-lg
                       flex items-center justify-center"
            >
                <i class="fas fa-user-plus mr-2"></i>
                Criar Conta
            </button>

            <!-- Link Login -->
            <div class="text-center pt-4">
                <p class="text-sm text-gray-600">
                    Já possui uma conta?
                    <a href="{{ route('login') }}"
                       class="text-brand-primary font-medium hover:text-brand-accent2 transition">
                        Entrar no sistema
                    </a>
                </p>
            </div>
        </form>
    </div>

</body>
</html>
