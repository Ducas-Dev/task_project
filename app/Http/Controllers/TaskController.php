<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Task;
use Illuminate\Validation\Rule;


class TaskController extends Controller
{
    public function login(){
        return view('login');
    }

    public function getTask(){
        try {
            $tasks = Task::latest()->paginate(4);

            $taskAttente = Task::where('status', 'en_attente')->count();
            $taskPending = Task::where('status', 'en_cours')->count();
            $taskFinish = Task::where('status', 'terminer')->count();

            return view('task', compact(
                'tasks',
                'taskAttente',
                'taskPending',
                'taskFinish'
            ));

        } catch (\Exception $th) {
            Log::error('Erreur lors de la création de la tâche', [
                'message' => $th->getMessage(),
                'exception' => get_class($th),
            ]);
            return back()->with('error', 'Une erreur est survenue : ' . $th->getMessage());
        }
    }


    public function createTask(){
        return view('create_task');
    }

    public function saveTask(Request $request, ?Task $task = null){
        
        $validated = $request->validate([
            'task' => ['required','string','max:255',Rule::unique('tasks', 'task')->ignore($task?->id)],
            'description' => 'nullable|string',
            'status' => 'required|in:en_attente,en_cours,terminer',
            'priorite' => 'required|in:faible,moyenne,elever',
            'date_echeance' => 'required|date|after_or_equal:today',
        ],[
            'task.required' => 'Le titre de la tâche est obligatoire.',
            'task.string' => 'Veuillez saisir des chaînes de caractères.',
            'task.max' => 'Titre trop long.',
            'description.string' => 'Veuillez saisir des chaînes de caractères.',
            'status.required' => 'Le status de la tâche est obligatoire.',
            'status.in' => 'status disponibles: "En attente","En cours","Terminée".',
            'priorite.required' => 'La priorité de la tâche est obligatoire.',
            'priorite.in' => 'status disponibles: "Faible","Moyenne","Elevée".',
            'date_echeance.required' => 'La date d\'échéance de la tâche est obligatoire.',
            'date_echeance.date' => 'Veuillez saisir une date.',
            'date_echeance.after_or_equal' => "La date d\'échéance ne peut pas être antérieure à aujourd'hui.",
        ]);

        try {
            DB::transaction(function () use ($validated, $task) {

                if ($task) {
                    // Modification
                    $task->update([
                        'task' => trim($validated['task']),
                        'description' => isset($validated['description'])
                            ? trim($validated['description'])
                            : null,
                        'status' => $validated['status'],
                        'priorite' => $validated['priorite'],
                        'date_echeance' => $validated['date_echeance'],
                    ]);
                } else {
                    // Création
                    Task::create([
                        'task' => trim($validated['task']),
                        'description' => isset($validated['description'])
                            ? trim($validated['description'])
                            : null,
                        'status' => $validated['status'],
                        'priorite' => $validated['priorite'],
                        'date_echeance' => $validated['date_echeance'],
                    ]);
                }
            });

            return redirect()->route('get.task')
                ->with('success',
                    $task
                        ? 'La tâche a été modifiée avec succès.'
                        : 'La tâche a été créée avec succès.',
                );

        } catch (\Throwable $th) {
            Log::error('Erreur lors de la création de la tâche', [
                'message' => $th->getMessage(),
                'exception' => get_class($th),
            ]);

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Impossible de créer la tâche.'
            );
        }
    }

    public function edit(Task $task){
        
        return view('create_task', compact('task'));
    }

    public function deleteTask(Task $task){
        try {

            $task->delete();

            return redirect()->route('get.task')->with(
                'success',
                'La tâche a été supprimée avec succès.'
            );

        } catch (\Throwable $th) {

        Log::error('Erreur suppression tâche', [
            'message' => $th->getMessage(),
        ]);

        return back()->with(
            'error',
            'Une erreur est survenue lors de la suppression.'
        );
    }
}

}
