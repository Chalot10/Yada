<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <title>Cartão de Visita - Yada Key</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Poppins:wght@300;400;600&display=swap');
        body { font-family: 'Poppins', sans-serif; }
    </style>
</head>
<body class="bg-gray-200 flex flex-col items-center justify-center min-h-screen gap-10 p-5">

    <div class="w-[500px] h-[280px] bg-white shadow-xl rounded-lg relative overflow-hidden flex flex-col items-center justify-center border-t-8 border-blue-900">
        <div class="absolute top-0 right-0 w-32 h-32 bg-amber-400 opacity-10 rounded-bl-full"></div>
        
        <img src="{{ asset('img/YADA_noBG.png') }}" alt="Logo Yada Key" class="h-24 mb-4">
        
        <div class="text-center px-6">
            <h1 class="text-blue-900 font-bold text-lg tracking-widest uppercase">Yada Key Consulting and Services, SU, Lda.</h1>
            <p class="text-amber-600 italic text-sm mt-1">"A chave do sucesso da sua empresa."</p>
        </div>
        
        <div class="absolute bottom-0 w-full h-2 bg-gradient-to-r from-blue-900 via-blue-700 to-blue-900"></div>
    </div>

    <div class="w-[500px] h-[280px] bg-slate-900 shadow-xl rounded-lg relative overflow-hidden flex text-white">
        <div class="w-3 bg-amber-500"></div>
        
        <div class="flex-grow p-8 flex flex-col justify-between">
            <div>
                <h2 class="text-2xl font-bold tracking-wide text-amber-400">Victoria Isaias Chave</h2>
                <p class="text-sm uppercase tracking-[0.2em] text-gray-300 mt-1 font-light">Directora</p>
            </div>

            <div class="text-[10px] text-gray-400 uppercase tracking-wider space-x-2">
                <span>Contabilidade</span> • <span>Recursos Humanos</span> • <span>Registo de Empresas</span>
            </div>

            <div class="space-y-3 border-t border-gray-700 pt-4">
                <div class="flex items-center text-sm">
                    <div class="w-8 h-8 rounded-full bg-blue-900 flex items-center justify-center mr-3">
                        <i class="fas fa-phone-alt text-amber-400 text-xs"></i>
                    </div>
                    <span class="font-medium text-lg tracking-wider">848924275</span>
                </div>
                
                <div class="flex items-center text-xs text-gray-300">
                    <div class="w-8 h-8 rounded-full bg-blue-900 flex items-center justify-center mr-3">
                        <i class="fas fa-map-marker-alt text-amber-400"></i>
                    </div>
                    <span>Av. Moçambique, Maputo, Moçambique</span>
                </div>
            </div>
        </div>

        <div class="absolute top-6 right-6 opacity-20">
            <img src="https://i.ibb.co/v6m8p9z/YADA-Logo.png" alt="Icon" class="h-16 grayscale brightness-200">
        </div>
    </div>

</body>
</html>