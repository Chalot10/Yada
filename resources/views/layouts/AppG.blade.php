<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'SIGEA') }}</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
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
            @include('partials.sidebarGestora')

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
