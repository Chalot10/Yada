<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <title>Cartaz Yada Key Consulting</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Poppins:wght@300;400;600&display=swap');
        body { font-family: 'Poppins', sans-serif; }
        .serif { font-family: 'Playfair+Display', serif; }
        .gradient-banner {
            background: linear-gradient(90deg, #1e3a8a 0%, #3b82f6 50%, #1e3a8a 100%);
            border-top: 3px solid #d4af37;
            border-bottom: 3px solid #d4af37;
        }
    </style>
</head>
<body class="bg-gray-100 flex justify-center p-4">

    <div class="w-[794px] min-h-[1123px] bg-white shadow-2xl relative overflow-hidden flex flex-col">
        
        <div class="absolute inset-0 opacity-10 pointer-events-none">
            <img src="https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?auto=format&fit=crop&q=80&w=1000" alt="background" class="w-full h-full object-cover">
        </div>

        <div class="relative z-10 pt-12 text-center">
            <div class="flex justify-center mb-4">
                <img src="{{ asset('img/YADA_noBG.png') }}" alt="Logo Yada Key" class="h-40">
            </div>
            <h1 class="text-2xl text-blue-900 font-semibold tracking-widest uppercase mb-1">Yada Key Consulting and Services, SU, Lda.</h1>
            <p class="text-xl italic text-blue-800 font-light">"A chave do sucesso da sua empresa."</p>
        </div>

        <div class="relative z-10 mt-8 gradient-banner py-4 shadow-lg">
            <h2 class="text-center text-white text-3xl font-bold tracking-widest uppercase">
                Consultoria de Contabilidade
            </h2>
        </div>

        <div class="relative z-10 grid grid-cols-2 gap-8 px-12 mt-10 flex-grow">
            
            <div class="space-y-6">
                <div>
                    <div class="flex items-center mb-3">
                        <i class="fas fa-briefcase text-amber-500 text-2xl mr-3"></i>
                        <h3 class="text-xl font-bold text-blue-900 uppercase">Abertura e Registo</h3>
                    </div>
                    <ul class="space-y-2 text-gray-700 border-l-2 border-amber-400 pl-4">
                        <li><i class="fas fa-check text-amber-600 mr-2"></i> Reserva de nome</li>
                        <li><i class="fas fa-check text-amber-600 mr-2"></i> Elaboração de estatutos</li>
                        <li><i class="fas fa-check text-amber-600 mr-2"></i> Registo fiscal e obtenção de NUIT</li>
                        <li><i class="fas fa-check text-amber-600 mr-2"></i> Alvará e início de actividades</li>
                        <li><i class="fas fa-check text-amber-600 mr-2"></i> Registo de INSS</li>
                    </ul>
                </div>

                <div>
                    <div class="flex items-center mb-3">
                        <i class="fas fa-calculator text-amber-500 text-2xl mr-3"></i>
                        <h3 class="text-xl font-bold text-blue-900 uppercase">Contabilidade</h3>
                    </div>
                    <ul class="space-y-2 text-gray-700 border-l-2 border-amber-400 pl-4">
                        <li><i class="fas fa-check text-amber-600 mr-2"></i> Lançamento e arquivo de documentos</li>
                        <li><i class="fas fa-check text-amber-600 mr-2"></i> Pagamentos de impostos mensais</li>
                        <li><i class="fas fa-check text-amber-600 mr-2"></i> Contratos de sociedade</li>
                        <li><i class="fas fa-check text-amber-600 mr-2"></i> Elaboração de Actas bancárias</li>
                        <li><i class="fas fa-check text-amber-600 mr-2"></i> Processamento de IRPS e INSS</li>
                    </ul>
                </div>
            </div>

            <div class="space-y-6">
                <div class="bg-blue-50 p-6 rounded-lg border border-blue-100 shadow-sm">
                    <div class="flex items-center mb-4">
                        <i class="fas fa-users text-amber-500 text-2xl mr-3"></i>
                        <h3 class="text-xl font-bold text-blue-900 uppercase">Recursos Humanos</h3>
                    </div>
                    <ul class="space-y-3 text-gray-700">
                        <li class="flex items-start">
                            <i class="fas fa-file-invoice-dollar text-blue-600 mt-1 mr-3"></i>
                            <span>Emissão de guias de INSS</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-file-invoice-dollar text-blue-600 mt-1 mr-3"></i>
                            <span>Emissão de guias de IRPS</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-money-check-alt text-blue-600 mt-1 mr-3"></i>
                            <span>Folha de salário</span>
                        </li>
                    </ul>
                </div>
                
                <p class="text-blue-900 italic font-medium text-center mt-10">
                    "Entre em contacto connosco e simplifique os processos da sua empresa!"
                </p>
            </div>
        </div>

        <div class="relative z-10 bg-slate-900 text-white p-8 mt-auto">
            <div class="grid grid-cols-2 items-center">
                <div class="space-y-2">
                    <p class="text-amber-400 font-bold text-lg">Victoria Isaias Chave</p>
                    <p class="text-sm tracking-widest uppercase opacity-80">Directora</p>
                </div>
                <div class="text-right space-y-2">
                    <p class="flex justify-end items-center">
                        <span class="mr-3 font-semibold text-xl">848924275</span>
                        <i class="fas fa-phone-alt text-amber-500"></i>
                    </p>
                    <p class="flex justify-end items-center text-sm opacity-90">
                        <span class="mr-3">Av. Moçambique, Maputo, Moçambique</span>
                        <i class="fas fa-map-marker-alt text-amber-500"></i>
                    </p>
                </div>
            </div>
        </div>

    </div>

</body>
</html>