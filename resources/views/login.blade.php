<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <title>Connexion</title>
</head>

<body class="min-h-screen">

    <div class="flex min-h-screen items-center justify-center px-4">

        <div class="w-full max-w-md">

            <div class="mb-8 text-center text-white">

                <h1 class="text-3xl font-bold">
                    Bienvenue !
                </h1>

                <p class="mt-2 text-white/80">
                    Connectez-vous à votre compte
                </p>
            </div>

            <div class="rounded-3xl bg-white p-8 shadow-2xl">

                <form method="POST" action="" class="space-y-5">
                    @csrf

                    <div>
                        <label for="email" class="mb-2 block text-sm font-medium text-gray-700">
                            Adresse email
                        </label>

                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="vous@example.com" 
                            class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 outline-none transition focus:border-indigo-500 focus:bg-white focus:ring-4 focus:ring-indigo-500/10">
                        @error('email')
                            <p class="mt-2 text-sm text-red-500">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div>
                        <div class="mb-2 flex items-center justify-between">
                            <label for="password"
                                class="block text-sm font-medium text-gray-700">
                                Mot de passe
                            </label>

                            <a
                                href="#"
                                class="text-sm font-medium text-indigo-600 hover:text-indigo-500"
                            >
                                Mot de passe oublié ?
                            </a>
                        </div>

                        <input id="password" type="password" name="password" required placeholder="......"
                            class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 outline-none transition focus:border-indigo-500 focus:bg-white focus:ring-4 focus:ring-indigo-500/10">
                    </div>

                    <button type="submit"
                        class="w-full rounded-xl bg-indigo-600 px-4 py-3 font-semibold text-white shadow-lg shadow-indigo-500/30 transition hover:-translate-y-0.5 hover:bg-indigo-700 active:translate-y-0">
                        Se connecter
                    </button>

                </form>

                <div class="mt-6 text-center">
                    <p class="text-sm text-gray-500">
                        Vous n'avez pas encore de compte ?
                        <a
                            href="#"
                            class="font-semibold text-indigo-600 hover:text-indigo-500"
                        >
                            Créer un compte
                        </a>
                    </p>
                </div>

            </div>

            <p class="mt-6 text-center text-sm text-white/70">
                © {{ date('Y') }} Mon Application
            </p>

        </div>

    </div>

</body>
</html>