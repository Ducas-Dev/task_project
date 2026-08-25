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

            <a href="{{ route('create.task')}}"
                class="rounded-xl bg-indigo-600 px-5 py-3 font-semibold text-white shadow-lg shadow-indigo-500/20 transition hover:bg-indigo-700">
                + Nouvelle tâche
            </a>

        </div>
</nav>