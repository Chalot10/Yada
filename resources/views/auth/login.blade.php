<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Yada Key Consulting and Services</title>
    <!-- Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Fonte profissional -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Ícones -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            font-family: 'Inter', sans-serif;
        }
        .brand-primary { background-color: #03588C; }
        .brand-secondary { background-color: #024059; }
        .brand-light { background-color: #F2F2F2; }
        .brand-accent1 { background-color: #F2B84B; }
        .brand-accent2 { background-color: #D97B29; }
        
        .text-brand-primary { color: #03588C; }
        .text-brand-secondary { color: #024059; }
        .text-brand-light { color: #F2F2F2; }
        .text-brand-accent1 { color: #F2B84B; }
        .text-brand-accent2 { color: #D97B29; }
        
        .border-brand-primary { border-color: #03588C; }
        .border-brand-accent1 { border-color: #F2B84B; }
        
        .focus\:ring-brand-primary:focus { ring-color: #03588C; }
        
        .login-btn {
            background-color: #F2B84B;
            color: #024059;
            transition: all 0.3s ease;
        }
        
        .login-btn:hover {
            background-color: #D97B29;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(217, 123, 41, 0.3);
        }
        
        /* Responsividade para telas muito pequenas */
        @media (max-width: 360px) {
            .text-4xl { font-size: 1.875rem; }
            .text-2xl { font-size: 1.5rem; }
            .text-xl { font-size: 1.25rem; }
            .p-10 { padding: 1.5rem; }
            .p-6 { padding: 1rem; }
        }
    </style>
</head>
<body class="bg-brand-light min-h-screen flex items-center justify-center p-2 sm:p-4">
    <div class="flex flex-col md:flex-row w-full max-w-6xl rounded-lg md:rounded-2xl overflow-hidden shadow-lg md:shadow-2xl mx-2">
        <!-- Painel esquerdo com informações da empresa -->
        <div class="brand-primary md:w-2/5 p-4 sm:p-6 md:p-8 lg:p-10 text-white flex flex-col justify-between">
            <!-- Área do Logotipo da Empresa -->
            <div class="mb-6 md:mb-8 lg:mb-10">
                <div class="flex flex-col items-center justify-center mb-6 md:mb-8">
                    <!-- Logotipo criativo usando as cores da empresa -->
                    <div class="relative w-32 h-32 sm:w-40 sm:h-40 md:w-48 md:h-48 mb-4 sm:mb-5 md:mb-6">
                        <!-- Fundo do logotipo -->
                        <div class="absolute inset-0 bg-white rounded-2xl md:rounded-3xl flex items-center justify-center">
                            <div class="relative w-28 h-28 sm:w-32 sm:h-32 md:w-40 md:h-40">
                                <!-- Elementos do logotipo usando as cores fornecidas -->
                                <div class="absolute top-0 left-0 w-12 h-12 sm:w-16 sm:h-16 md:w-20 md:h-20 brand-accent1 rounded-full opacity-90"></div>
                                <div class="absolute bottom-0 right-0 w-12 h-12 sm:w-16 sm:h-16 md:w-20 md:h-20 brand-accent2 rounded-full opacity-90"></div>
                                <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-16 h-16 sm:w-20 sm:h-20 md:w-24 md:h-24 brand-secondary rounded-full opacity-80"></div>
                                <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-10 h-10 sm:w-12 sm:h-12 md:w-16 md:h-16 brand-primary rounded-full"></div>
                                <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-6 h-6 sm:w-7 sm:h-7 md:w-8 md:h-8 brand-light rounded-full"></div>
                                
                                <!-- Letra "Y" no centro -->
                                <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 text-2xl sm:text-3xl md:text-4xl font-bold text-brand-secondary z-10">
                                    Y
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Nome da empresa -->
                    <div class="text-center">
                        <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold tracking-wide">YADA KEY</h1>
                        <div class="h-1 w-20 sm:w-24 md:w-32 mx-auto bg-brand-accent1 my-2 sm:my-3 rounded-full"></div>
                        <p class="text-lg sm:text-xl md:text-xl brand-accent1 font-semibold">Consulting and Services</p>
                        <p class="text-xs sm:text-sm text-brand-light opacity-90 mt-1 sm:mt-2">SU, Lda.</p>
                    </div>
                </div>
                
                <div class="text-center">
                    <h2 class="text-lg sm:text-xl md:text-2xl font-semibold mb-2 sm:mb-3 md:mb-4">Excelência em Consultoria Empresarial</h2>
                    <p class="text-brand-light opacity-90 text-sm sm:text-base">
                        Transformando desafios em oportunidades através de soluções estratégicas inovadoras.
                    </p>
                </div>
            </div>
            
            <!-- Rodapé -->
            <div class="mt-6 sm:mt-8 md:mt-10 pt-4 sm:pt-5 md:pt-6 border-t border-white/20">
                <p class="text-xs sm:text-sm opacity-80 text-center">© 2025 Yada Key Consulting and Services, SU, Lda.</p>
            </div>
        </div>


        
        <!-- Painel direito com formulário de login -->
        <div class="bg-white md:w-3/5 p-4 sm:p-6 md:p-8 lg:p-10 xl:p-14">
            <div class="max-w-md mx-auto w-full">
                <div class="text-center mb-6 sm:mb-8 md:mb-10">
                    <h2 class="text-xl sm:text-2xl md:text-3xl font-bold text-brand-secondary mb-1 sm:mb-2">Acesso ao Sistema</h2>
                    <p class="text-gray-600 text-sm sm:text-base">Entre com suas credenciais para acessar o painel</p>
                </div>
                

                        <!-- Separador vertical para telas maiores -->
                @if ($errors->any())
                    <div class="mb-4 p-4 rounded-lg bg-red-100 border border-red-300 text-red-700">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $erro)
                                <li>{{ $erro }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif



                <form action="{{ route('login.authenticate') }}" method="POST" class="space-y-4 sm:space-y-5 md:space-y-6">
                    @csrf

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1 sm:mb-2">
                            <i class="fas fa-envelope text-brand-primary mr-1 sm:mr-2"></i>Endereço de Email
                        </label>
                        <div class="relative">
                            <input 
                                type="email" 
                                id="email" 
                                name="email"
                                required
                                class="w-full px-3 sm:px-4 py-2 sm:py-3 pl-10 sm:pl-12 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-brand-primary focus:border-transparent transition text-sm sm:text-base"
                                placeholder="seu.email@exemplo.com"
                            >
                            <div class="absolute left-3 sm:left-4 top-2.5 sm:top-3.5 text-gray-400">
                                <i class="fas fa-envelope text-sm sm:text-base"></i>
                            </div>
                        </div>
                    </div>
                    
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1 sm:mb-2">
                            <i class="fas fa-lock text-brand-primary mr-1 sm:mr-2"></i>Senha
                        </label>
                        <div class="relative">
                            <input 
                                type="password" 
                                id="password" 
                                name="password"
                                required
                                class="w-full px-3 sm:px-4 py-2 sm:py-3 pl-10 sm:pl-12 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-brand-primary focus:border-transparent transition text-sm sm:text-base"
                                placeholder="Digite sua senha"
                            >
                            <div class="absolute left-3 sm:left-4 top-2.5 sm:top-3.5 text-gray-400">
                                <i class="fas fa-lock text-sm sm:text-base"></i>
                            </div>
                            <button type="button" id="togglePassword" class="absolute right-3 sm:right-4 top-2.5 sm:top-3.5 text-gray-400 hover:text-brand-primary">
                                <i class="fas fa-eye text-sm sm:text-base"></i>
                            </button>
                        </div>
                    </div>
                    
                    <div class="flex flex-col xs:flex-row xs:items-center xs:justify-between space-y-3 xs:space-y-0">
                        <div class="flex items-center">
                            <input 
                                type="checkbox" 
                                id="remember" 
                                name="remember"
                                class="h-4 w-4 text-brand-primary focus:ring-brand-primary border-gray-300 rounded"
                            >
                            <label for="remember" class="ml-2 block text-sm text-gray-700">
                                Lembrar-me
                            </label>
                        </div>
                        
                        <a 
                            href="#" 
                            id="forgotPassword" 
                            class="text-sm font-medium text-brand-primary hover:text-brand-accent2 transition inline-block"
                        >
                            <i class="fas fa-question-circle mr-1"></i>Esqueceu sua senha?
                        </a>

                                            <div class="mt-4 text-center">
                        <p class="text-sm text-gray-600">
                            Não possui uma conta?
                            <a href="{{ route('register') }}" class="text-brand-primary font-medium hover:text-brand-accent2 transition">
                                Registre-se aqui
                            </a>
                        </p>
                    </div>

                    </div>
                    
                    <div>
                        <!-- Botão de Login com cor visível e destaque -->
                        <button 
                            type="submit" 
                            class="login-btn w-full py-2.5 sm:py-3 px-4 rounded-lg font-bold text-base sm:text-lg shadow-md sm:shadow-lg transition duration-300 flex items-center justify-center"
                        >
                            <i class="fas fa-sign-in-alt mr-2 sm:mr-3"></i>
                            <span class="text-sm sm:text-base md:text-lg">ENTRAR NO SISTEMA</span>
                        </button>
                    </div>
                </form>
                
                <!-- Modal de recuperação de senha (inicialmente oculto) -->
                <div id="passwordRecoveryModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-2 sm:p-4 z-50 hidden">
                    <div class="bg-white rounded-lg sm:rounded-xl md:rounded-2xl shadow-xl sm:shadow-2xl max-w-md w-full p-4 sm:p-5 md:p-6 mx-2">
                        <div class="flex justify-between items-center mb-4 sm:mb-5 md:mb-6">
                            <div class="flex items-center">
                                <div class="w-8 h-8 sm:w-9 sm:h-9 md:w-10 md:h-10 rounded-full bg-brand-accent1 flex items-center justify-center mr-2 sm:mr-3">
                                    <i class="fas fa-key text-brand-secondary text-sm sm:text-base"></i>
                                </div>
                                <h3 class="text-lg sm:text-xl md:text-xl font-bold text-brand-secondary">Recuperação de Senha</h3>
                            </div>
                            <button id="closeModal" class="text-gray-500 hover:text-gray-700">
                                <i class="fas fa-times text-lg sm:text-xl"></i>
                            </button>
                        </div>
                        
                        <p class="text-gray-600 text-sm sm:text-base mb-4 sm:mb-5 md:mb-6">
                            Digite seu email cadastrado abaixo. Enviaremos um link seguro para redefinir sua senha.
                        </p>
                        
                        <form id="recoveryForm">
                            <div class="mb-4 sm:mb-5 md:mb-6">
                                <label for="recoveryEmail" class="block text-sm font-medium text-gray-700 mb-1 sm:mb-2">
                                    <i class="fas fa-envelope text-brand-primary mr-1 sm:mr-2"></i>Email de recuperação
                                </label>
                                <div class="relative">
                                    <input 
                                        type="email" 
                                        id="recoveryEmail" 
                                        required
                                        class="w-full px-3 sm:px-4 py-2 sm:py-3 pl-10 sm:pl-12 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-brand-primary focus:border-transparent text-sm sm:text-base"
                                        placeholder="seu.email@exemplo.com"
                                    >
                                    <div class="absolute left-3 sm:left-4 top-2.5 sm:top-3.5 text-gray-400">
                                        <i class="fas fa-envelope text-sm sm:text-base"></i>
                                    </div>
                                </div>
                                <p class="text-xs text-gray-500 mt-1">Digite o mesmo email que você usa para fazer login</p>
                            </div>
                            
                            <div class="flex flex-col xs:flex-row justify-end space-y-2 xs:space-y-0 xs:space-x-2 sm:space-x-3 md:space-x-4">
                                <button 
                                    type="button" 
                                    id="cancelRecovery"
                                    class="px-3 sm:px-4 md:px-5 py-2 sm:py-2.5 md:py-3 border border-gray-300 rounded-lg hover:bg-gray-50 transition font-medium text-sm sm:text-base"
                                >
                                    Cancelar
                                </button>
                                <!-- Botão para submeter o email de recuperação -->
                                <button 
                                    type="submit"
                                    class="px-3 sm:px-4 md:px-5 py-2 sm:py-2.5 md:py-3 bg-brand-primary text-white rounded-lg hover:opacity-90 transition font-medium flex items-center justify-center text-sm sm:text-base"
                                >
                                    <i class="fas fa-paper-plane mr-1 sm:mr-2"></i>
                                    <span class="whitespace-nowrap">Enviar Link</span>
                                </button>
                            </div>
                        </form>
                        
                        <div class="mt-4 sm:mt-5 md:mt-6 p-3 sm:p-4 bg-blue-50 rounded-lg border border-blue-100">
                            <div class="flex">
                                <div class="flex-shrink-0 pt-0.5">
                                    <i class="fas fa-info-circle text-blue-500 text-sm sm:text-base"></i>
                                </div>
                                <div class="ml-2 sm:ml-3">
                                    <h4 class="text-xs sm:text-sm font-medium text-blue-800">Importante</h4>
                                    <div class="mt-0.5 text-xs sm:text-sm text-blue-700">
                                        <p class="mb-1">• O link de recuperação expira em 24 horas</p>
                                        <p class="mb-1">• Verifique sua pasta de spam se não receber o email</p>
                                        <p>• Entre em contato com o administrador se tiver problemas</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Notificações (posicionadas para dispositivos móveis) -->
    <div id="successNotification" class="fixed top-4 left-4 right-4 sm:top-6 sm:right-6 sm:left-auto bg-green-100 border-l-4 border-green-500 text-green-700 p-3 sm:p-4 rounded-lg shadow-lg z-50 hidden transform transition-transform duration-300 -translate-y-full sm:translate-x-full">
        <div class="flex items-center">
            <i class="fas fa-check-circle text-green-500 mr-2 sm:mr-3 text-lg sm:text-xl"></i>
            <div>
                <p class="font-medium text-sm sm:text-base">Login realizado com sucesso!</p>
                <p class="text-xs sm:text-sm">Redirecionando para o painel...</p>
            </div>
        </div>
    </div>
    
    <div id="recoveryNotification" class="fixed top-4 left-4 right-4 sm:top-6 sm:right-6 sm:left-auto bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-3 sm:p-4 rounded-lg shadow-lg z-50 hidden transform transition-transform duration-300 -translate-y-full sm:translate-x-full">
        <div class="flex items-center">
            <i class="fas fa-paper-plane text-blue-500 mr-2 sm:mr-3 text-lg sm:text-xl"></i>
            <div>
                <p class="font-medium text-sm sm:text-base">Link de recuperação enviado!</p>
                <p class="text-xs sm:text-sm">Verifique sua caixa de email.</p>
            </div>
        </div>
    </div>
    
    <script>
        // Toggle visibilidade da senha
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordInput = document.getElementById('password');
            const icon = this.querySelector('i');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });
        
        // Abrir modal de recuperação de senha
        document.getElementById('forgotPassword').addEventListener('click', function(e) {
            e.preventDefault();
            document.getElementById('passwordRecoveryModal').classList.remove('hidden');
            // Limpar o campo de email ao abrir o modal
            document.getElementById('recoveryEmail').value = '';
            document.getElementById('recoveryEmail').focus();
        });
        
        // Fechar modal de recuperação de senha
        const closeModal = () => document.getElementById('passwordRecoveryModal').classList.add('hidden');
        document.getElementById('closeModal').addEventListener('click', closeModal);
        document.getElementById('cancelRecovery').addEventListener('click', closeModal);
        
        // Fechar modal ao clicar fora dele
        document.getElementById('passwordRecoveryModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });
        
        // Submissão do formulário de recuperação
        document.getElementById('recoveryForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const email = document.getElementById('recoveryEmail').value;
            
            // Validação básica de email
            if (!email || !email.includes('@') || !email.includes('.')) {
                alert('Por favor, insira um endereço de email válido.');
                return;
            }
            
            // Mostrar notificação de recuperação
            const notification = document.getElementById('recoveryNotification');
            notification.classList.remove('hidden');
            notification.classList.remove('-translate-y-full', 'translate-x-full');
            
            // Simular envio do email
            console.log(`Solicitação de recuperação de senha para: ${email}`);
            
            // Fechar modal após 1 segundo
            setTimeout(() => {
                closeModal();
                
                // Esconder notificação após 5 segundos
                setTimeout(() => {
                    if (window.innerWidth < 640) {
                        notification.classList.add('-translate-y-full');
                    } else {
                        notification.classList.add('translate-x-full');
                    }
                    setTimeout(() => {
                        notification.classList.add('hidden');
                    }, 300);
                }, 5000);
                
                // Resetar formulário
                this.reset();
            }, 1000);
        });
        
        // Submissão do formulário de login
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            const remember = document.getElementById('remember').checked;
            
            // Validação simples
            if (!email || !password) {
                alert('Por favor, preencha todos os campos.');
                return;
            }
            
            // Simulação de login bem-sucedido
            console.log('Tentativa de login com:', { email, password, remember });
            
            // Mostrar notificação de sucesso
            const notification = document.getElementById('successNotification');
            notification.classList.remove('hidden');
            notification.classList.remove('-translate-y-full', 'translate-x-full');
            
            // Simular redirecionamento após 2 segundos
            setTimeout(() => {
                if (window.innerWidth < 640) {
                    notification.classList.add('-translate-y-full');
                } else {
                    notification.classList.add('translate-x-full');
                }
                setTimeout(() => {
                    notification.classList.add('hidden');
                    // Em ambiente Laravel, você faria o submit real do formulário
                    // this.submit();
                }, 300);
            }, 2000);
        });
        
        // Adicionar efeitos visuais nos inputs
        const inputs = document.querySelectorAll('input');
        inputs.forEach(input => {
            // Efeito ao focar
            input.addEventListener('focus', function() {
                this.parentElement.classList.add('ring-2', 'ring-brand-primary', 'ring-opacity-30');
            });
            
            // Efeito ao perder foco
            input.addEventListener('blur', function() {
                this.parentElement.classList.remove('ring-2', 'ring-brand-primary', 'ring-opacity-30');
            });
        });
        
        // Adicionar efeito de digitação no campo de email do formulário de recuperação
        document.getElementById('recoveryEmail').addEventListener('input', function() {
            if (this.value.length > 0) {
                this.parentElement.classList.add('ring-1', 'ring-blue-300');
            } else {
                this.parentElement.classList.remove('ring-1', 'ring-blue-300');
            }
        });
        
        // Fechar modal com tecla ESC
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeModal();
            }
        });
    </script>
</body>
</html>
