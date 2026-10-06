<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('SIGEYADA') }}</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <div class="progress-bar absolute top-0 left-0 h-1 bg-blue-500"></div>
    
    {{-- <link rel="stylesheet" href="{{ asset('css/app.css') }}"> --}}

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'brand-primary': '#03588C',
                        'brand-secondary': '#024059',
                        'brand-light': '#F2F2F2',
                        'brand-accent1': '#F2B84B',
                        'brand-accent2': '#D97B29',
                    },
                }
            }
        }
    </script>

    <!-- No head -->
    {{-- <script src="https://unpkg.com/qrcode@1.5.3/build/qrcode.min.js"></script> --}}

    <!-- html2canvas para capturar imagem do recibo (opcional) -->
    <script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
        <!-- jsPDF para geração de PDF -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jspdf-autotable@3.5.28/dist/jspdf.plugin.autotable.min.js"></script>

    <!-- html2canvas para capturar elementos HTML -->
    <script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>

    <!-- QR Code Library -->
    <script src="https://cdn.jsdelivr.net/npm/qrcode@1.5.3/build/qrcode.min.js"></script>


    <script src="{{ asset('js/qrcode.min.js') }}"></script>

    <!-- Fontes para PDF -->
    <script src="https://cdn.jsdelivr.net/npm/@jsreport/browser-client/dist/jsreport.umd.js"></script>

    <!-- SweetAlert2 para confirmações -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body class="bg-brand-light font-sans text-sm text-brand-secondary">

    {{-- Loading Overlay --}}
    {{-- @include('partials.overlay') --}}

    <div id="app" class="flex flex-col min-h-screen">

        {{-- Header --}}
        @include('partials.header')

        {{-- Mobile Drawer --}}
        @auth
            @include('partials.mobile')
        @endauth

        {{-- Main Layout --}}
        <main class="flex flex-1 overflow-hidden">

            {{-- Sidebar --}}
            @include('partials.sidebar')

            {{-- Main Content --}}
            <section class="flex-1 overflow-y-auto p-4">
                @yield('content')
                @yield('scripts')
            </section>
        </main>

        {{-- Footer --}}
        @include('partials.footer')
    </div>

    {{-- Scripts --}}
    @include('partials.scripts')

</body>
</html>
