<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Diavolo Apparel</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white text-black m-0 p-0">

    @include('layouts.navbar')

    @yield('content')

    @include('layouts.footer')

        {{-- NOTIFIKASI TOAST --}}
    @if(session('success'))
    <div id="toast"
        class="fixed top-24 right-6 z-[9999] bg-black text-white font-montserrat text-sm px-6 py-4 shadow-xl flex items-center gap-3 translate-x-0 transition-all duration-500">
        <i class="fas fa-check-circle text-green-400 text-lg"></i>
        <span>{{ session('success') }}</span>
        <button onclick="closeToast()" class="ml-4 text-gray-400 hover:text-white transition-colors">
            <i class="fas fa-times text-xs"></i>
        </button>
    </div>
    @endif

    @if(session('error'))
    <div id="toast-error"
        class="fixed top-24 right-6 z-[9999] bg-red-600 text-white font-montserrat text-sm px-6 py-4 shadow-xl flex items-center gap-3 transition-all duration-500">
        <i class="fas fa-exclamation-circle text-white text-lg"></i>
        <span>{{ session('error') }}</span>
        <button onclick="closeToastError()" class="ml-4 text-white hover:text-gray-200 transition-colors">
            <i class="fas fa-times text-xs"></i>
        </button>
    </div>
    @endif

    <script>
        // Auto close toast setelah 3 detik
        setTimeout(() => {
            const toast = document.getElementById('toast');
            if (toast) {
                toast.style.opacity = '0';
                toast.style.transform = 'translateX(100%)';
                setTimeout(() => toast.remove(), 500);
            }
        }, 3000);

        setTimeout(() => {
            const toast = document.getElementById('toast-error');
            if (toast) {
                toast.style.opacity = '0';
                toast.style.transform = 'translateX(100%)';
                setTimeout(() => toast.remove(), 500);
            }
        }, 3000);

        function closeToast() {
            const toast = document.getElementById('toast');
            if (toast) {
                toast.style.opacity = '0';
                toast.style.transform = 'translateX(100%)';
                setTimeout(() => toast.remove(), 500);
            }
        }

        function closeToastError() {
            const toast = document.getElementById('toast-error');
            if (toast) {
                toast.style.opacity = '0';
                toast.style.transform = 'translateX(100%)';
                setTimeout(() => toast.remove(), 500);
            }
        }
    </script>

    @stack('scripts')

</body>
</html>