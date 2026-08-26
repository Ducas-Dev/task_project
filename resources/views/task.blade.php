@extends('layouts.app')
@section('title', 'Mes tâches')

@section('button')
    <a href="{{ route('create.task')}}" id="add-task"
        class="rounded-xl bg-indigo-600 px-5 py-3 font-semibold text-white shadow-lg shadow-indigo-500/20 transition hover:bg-indigo-700">
        + Nouvelle tâche
    </a>
@endsection

@section('content')
    <main class="mx-auto max-w-7xl mt-16 px-6 py-10">

        <div class="mb-8 grid gap-5 sm:grid-cols-4">

            <div class="rounded-2xl bg-white p-6 shadow-sm">
                <p class="text-sm text-gray-500">
                    Total
                </p>

                <p class="mt-2 text-3xl font-bold text-gray-900">
                    {{ count($tasks) }}
                </p>
            </div>

            <div class="rounded-2xl bg-white p-6 shadow-sm">
                <p class="text-sm text-gray-500">
                    En attente
                </p>

                <p class="mt-2 text-3xl font-bold text-gray-500">
                    {{ $taskAttente }}
                </p>
            </div>

            <div class="rounded-2xl bg-white p-6 shadow-sm">
                <p class="text-sm text-gray-500">
                    En cours
                </p>

                <p class="mt-2 text-3xl font-bold text-orange-500">
                    {{ $taskPending }}
                </p>
            </div>

            <div class="rounded-2xl bg-white p-6 shadow-sm">
                <p class="text-sm text-gray-500">
                    Terminées
                </p>

                <p class="mt-2 text-3xl font-bold text-green-500">
                    {{ $taskFinish }}
                </p>
            </div>

        </div>

        <div class="overflow-hidden rounded-2xl bg-white shadow-sm">

            <div class="shadow-md px-6 py-5">
                <h2 class="text-lg font-bold text-gray-900">
                    Mes tâches
                </h2>
            </div>

            <div class="flex my-4 mx-4 gap-4 lg:grid grid-cols-2">
            @forelse($tasks as $task)

                <div
                    class="group w-full max-w-2xl overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm transition-all duration-300 hover:-translate-y-1 hover:border-indigo-300 hover:shadow-xl">
                    <!-- En-tête -->
                    <div class="flex items-start justify-between border-b border-gray-100 p-5">
                        <div class="min-w-0">
                            <h3 class="truncate text-lg font-bold text-gray-900">
                                {{ $task->task }}
                            </h3>

                            @if($task->description)
                                <p class="mt-2 line-clamp-2 text-sm leading-6 text-gray-500">
                                    {{ Str::limit($task->description, 100, '...') }}
                                </p>
                            @else
                                <p class="mt-2 text-sm italic text-gray-400">
                                    Aucune description
                                </p>
                            @endif
                        </div>

                        <!-- Icône -->
                        <div class="ml-4 flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600">
                            ✓
                        </div>
                    </div>


                    <!-- Informations -->
                    <div class="space-y-4 p-5">

                        <div class="flex flex-wrap gap-2">

                            <!-- Statut -->
                            @if($task->status === 'terminer')
                                <span class="inline-flex items-center rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700">
                                    Terminée
                                </span>
                            @elseif($task->status === 'en_cours')
                                <span class="inline-flex items-center rounded-full bg-blue-100 px-3 py-1 text-xs font-semibold text-blue-700">
                                    En cours
                                </span>
                            @else
                                <span class="inline-flex items-center rounded-full bg-orange-100 px-3 py-1 text-xs font-semibold text-orange-700">
                                    En attente
                                </span>
                            @endif


                            <!-- Priorité -->
                            @if($task->priorite === 'elever')
                                <span class="inline-flex items-center rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-700">
                                    Priorité élevée
                                </span>
                            @elseif($task->priorite === 'moyenne')
                                <span class="inline-flex items-center rounded-full bg-yellow-100 px-3 py-1 text-xs font-semibold text-yellow-700">
                                    Priorité moyenne
                                </span>
                            @else
                                <span class="inline-flex items-center rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700">
                                    Priorité faible
                                </span>
                            @endif

                        </div>


                        <!-- Dates -->
                        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">

                            <div class="rounded-xl bg-gray-50 p-3">
                                <p class="text-xs font-medium text-gray-400">
                                    Créée le
                                </p>

                                <p class="mt-1 text-sm font-semibold text-gray-700">
                                    {{ $task->created_at?->format('d/m/Y') }}
                                </p>
                            </div>


                            <div class="rounded-xl bg-gray-50 p-3">
                                <p class="text-xs font-medium text-gray-400">
                                    Échéance
                                </p>

                                <p class="mt-1 text-sm font-semibold text-gray-700">
                                    {{ \Carbon\Carbon::parse($task->date_echeance)->format('d/m/Y') }}
                                </p>
                            </div>

                        </div>

                    </div>


                    <!-- Actions -->
                    <div class="flex items-center justify-end gap-3 border-t border-gray-100 bg-gray-50/50 p-4">


                        <!-- Modifier -->
                        <a href="{{ route('edit.task',['task' => $task->id]) }}"
                            class="rounded-xl bg-indigo-50 px-4 py-2 text-sm font-semibold text-indigo-600 transition hover:bg-indigo-100"
                        >
                            Modifier
                        </a>


                        <!-- Supprimer -->
                        <form
                            action="{{ route('delete.task',['task' => $task->id]) }}"
                            method="POST"
                            onsubmit="return confirm('Voulez-vous vraiment supprimer cette tâche ?')"
                        >
                            @csrf
                            @method('DELETE')

                            <button
                                type="submit"
                                class="rounded-xl bg-red-50 px-4 py-2 text-sm font-semibold text-red-600 transition hover:bg-red-100"
                            >
                                Supprimer
                            </button>
                        </form>

                    </div>

                </div>

            @empty

                <div class="col-span-full flex min-h-[300px] items-center justify-center">
                    <div class="text-center">

                        <h3 class="mt-4 font-semibold text-gray-900">
                            Aucune tâche
                        </h3>

                        <p class="mt-2 text-sm text-gray-500">
                            Vous n'avez aucune tâche pour le moment.
                        </p>

                        <a href="{{ route('create.task') }}"
                        class="mt-5 inline-flex rounded-xl bg-indigo-600 px-5 py-3 font-semibold text-white transition hover:bg-indigo-700">
                            + Créer une tâche
                        </a>
                    </div>
                </div>

            @endforelse

            </div>

            <div class="flex justify-center px-6 py-4">
                {{ $tasks->links() }}
            </div>

        </div>

    </main>
@endsection