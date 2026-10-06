<!-- Loading Overlay -->
<div id="loading-overlay" class="fixed inset-0 bg-gradient-to-br from-slate-50 to-blue-50 z-[9999] flex items-center justify-center">
    <div class="text-center p-4">
        <!-- Logo -->
        <div class="flex flex-col mb-8 p-4 mx-auto">
            <img src="{{ asset('img/upm-heraldica.png') }}" alt="Heraldica SIGEYADA" class="w-24 mx-auto mb-1">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">{{ 'SIGEYADA' }}</h1>
            <h2 class="text-md text-gray-600 mb-4">Sistema de Gestão Yada Consulting and Services</h2>
        </div>
        
        <!-- Loading Text -->
        <div class="mb-4">
            <div class="h-1 w-48 bg-gray-200 rounded-full mx-auto overflow-hidden">
                <div class="h-full bg-gradient-to-r from-blue-500 to-blue-600 rounded-full" style="width: 100%; animation: progressBar 2s ease-in-out infinite;"></div>
            </div>
        </div>
        
        <!-- Inspirational Quote -->
        <div class="max-w-md mx-auto">
            <blockquote class="text-gray-600 italic text-sm" id="loading-quote">
                "A educação é a arma mais poderosa que você pode usar para mudar o mundo."
            </blockquote>
            <cite class="block text-xs text-gray-500 mt-2" id="loading-author">— Nelson Mandela</cite>
        </div>
    </div>
</div>