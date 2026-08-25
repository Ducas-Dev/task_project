<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

    <title>@yield('title', 'TaskManager')</title>

</head>

<body class="min-h-screen bg-gray-100"> 
    <nav class="shadow-lg fixed top-0 left-0 w-full bg-white">
            <div class="mx-auto flex max-w-7xl items-center justify-between px-6 py-4">

                <div>
                    <h1 class="text-xl font-bold text-gray-900">
                        TaskManager
                    </h1>

                    <p class="text-sm text-gray-500">
                        Gestion de vos tâches
                    </p>
                </div>

                @yield('button')

            </div>
    </nav>

    @yield('content')
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    @if(session('success'))
        <script>
            Toastify({
                text: "{{ session('success') }}",
                duration: 4000,
                gravity: "top",
                position: "right",
                close: true,
                stopOnFocus: true,
                style: {
                    background: "#10b981",
                    borderRadius: "12px",
                    boxShadow: "0 10px 25px rgba(0,0,0,0.15)"
                }
            }).showToast();
        </script>
    @endif

    @if(session('error'))
        <script>
            Toastify({
                text: "{{ session('error') }}",
                duration: 4000,
                gravity: "top",
                position: "right",
                close: true,
                stopOnFocus: true,
                style: {
                    background: "#10b981",
                    borderRadius: "12px",
                    boxShadow: "0 10px 25px rgba(0,0,0,0.15)"
                }
            }).showToast();
        </script>
    @endif

</body>
</html>