@extends('layouts.app')
@section("title","Create task")

@section('button')
    <a
        href="{{route('get.task')}}" 
        class="rounded-xl bg-red-700 px-4 py-2 text-sm font-medium text-white hover:bg-red-200">
            Retour
    </a>
@endsection


@section('content')
    <main class="mx-auto max-w-3xl mt-16 px-6 py-10">

            <!-- Titre -->
            <div class="mb-8">

                <h1>
                    {{ isset($task) ? 'Modifier la tâche' : 'Créer une tâche' }}
                </h1>


                <p class="mt-2 text-gray-500">
                    Ajoutez une nouvelle tâche à votre liste.
                </p>

            </div>


            <!-- Formulaire -->
            <div class="rounded-3xl bg-white p-8 shadow-sm">

                <form method="POST" action="{{ isset($task) ? route('update.task', ['task' => $task->id]) : route('save.task') }}" class="space-y-6">
                    @csrf

                    @if(isset($task))
                        @method('PUT')
                    @endif

                    <!-- Titre -->
                    <div>

                        <label for="title" class="mb-2 block text-sm font-semibold text-gray-700">
                            Titre de la tâche
                        </label>

                        <input type="text" name="task" value="{{ old('task', $task->task ?? '') }}" placeholder="Ex : Terminer le projet partie 2" class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-gray-900 outline-none transition placeholder:text-gray-400 focus:border-indigo-500 focus:bg-white focus:ring-4 focus:ring-indigo-500/10">

                        @error('task')
                            <p class="mt-2 text-sm text-red-500">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>


                    <div>

                        <label for="description" class="mb-2 block text-sm font-semibold text-gray-700">
                            Description
                        </label>

                        <textarea
                            id="description"
                            name="description"
                            rows="5"
                            placeholder="Décrivez votre tâche..."
                            class="w-full resize-none rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-gray-900 outline-none transition placeholder:text-gray-400 focus:border-indigo-500 focus:bg-white focus:ring-4 focus:ring-indigo-500/10"
                        >{{ old('description', $task->description ?? '') }}</textarea>

                        @error('description')
                            <p class="mt-2 text-sm text-red-500">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>


                    <!-- Date + priorité -->
                    <div class="grid gap-6 md:grid-cols-2">

                        <!-- Date -->
                        <div>

                            <label
                                for="due_date"
                                class="mb-2 block text-sm font-semibold text-gray-700"
                            >
                                Date d'échéance
                            </label>

                            <input
                                id="date_echeance"
                                type="date"
                                name="date_echeance"
                                value="{{ old('date_echeance', $task->date_echeance ?? '') }}"
                                class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-gray-900 outline-none transition focus:border-indigo-500 focus:bg-white focus:ring-4 focus:ring-indigo-500/10"
                            >

                            @error('date_echeance')
                                <p class="mt-2 text-sm text-red-500">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>


                        <!-- Priorité -->
                        <div>

                            <label
                                for="priority"
                                class="mb-2 block text-sm font-semibold text-gray-700"
                            >
                                Priorité
                            </label>

                            <select name="priorite"
                                class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-gray-900 outline-none transition focus:border-indigo-500 focus:bg-white focus:ring-4 focus:ring-indigo-500/10"
                            >
                                    <option value="faible"
                                        @selected(old('priorite', $task->priorite ?? 'moyenne') === 'faible')>
                                        Faible
                                    </option>

                                    <option value="moyenne"
                                        @selected(old('priorite', $task->priorite ?? 'moyenne') === 'moyenne')>
                                        Moyenne
                                    </option>

                                    <option value="elever"
                                        @selected(old('priorite', $task->priorite ?? 'moyenne') === 'elever')>
                                        Élevée
                                    </option>
                                </select>


                            @error('priorite')
                                <p class="mt-2 text-sm text-red-500">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>

                    </div>


                    <!-- Statut -->
                    <div>

                        <label
                            for="status"
                            class="mb-2 block text-sm font-semibold text-gray-700"
                        >
                            Statut
                        </label>

                        <select
                            id="status"
                            name="status"
                            class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-gray-900 outline-none transition focus:border-indigo-500 focus:bg-white focus:ring-4 focus:ring-indigo-500/10"
                        >
                            <option value="en_attente"
                                @selected(old('status', $task->status ?? 'en_attente') === 'en_attente')>
                                En attente
                            </option>

                            <option value="en_cours"
                                @selected(old('status', $task->status ?? 'en_attente') === 'en_cours')>
                                En cours
                            </option>

                            <option value="terminer"
                                @selected(old('status', $task->status ?? 'en_attente') === 'terminer')>
                                Terminée
                            </option>
                        </select>

                        @error('status')
                            <p class="mt-2 text-sm text-red-500">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>


                    <!-- Séparateur -->
                    <div class="border-t"></div>


                    <!-- Actions -->
                    <div class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">

                        <a
                            href="#"
                            class="rounded-xl px-6 py-3 text-center font-medium text-gray-600 transition hover:bg-gray-100"
                        >
                            Annuler
                        </a>

                        <button
                            type="submit"
                            class="rounded-xl bg-indigo-600 px-6 py-3 font-semibold text-white shadow-lg shadow-indigo-500/20 transition hover:bg-indigo-700"
                        >
                            {{ isset($task) ? 'Modifier la tâche' : '+ Créer la tâche' }}
                        </button>


                    </div>

                </form>

            </div>

        </main>

    
@endsection