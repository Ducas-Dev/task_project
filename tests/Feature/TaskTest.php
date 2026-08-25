<?php

namespace Tests\Feature;

use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Carbon\Carbon;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Vérifie que la page des tâches est accessible.
     */
    public function test_la_page_des_taches_est_accessible(): void
    {
        $response = $this->get(route('get.task'));

        $response->assertStatus(200);
        $response->assertViewIs('task');
    }

    /**
     * Vérifie qu'une tâche peut être créée.
     */
    public function test_un_utilisateur_peut_creer_une_tache(): void
    {
        $this->withoutMiddleware();

        $response = $this->post(route('save.task'), [
            'task' => 'Apprendre Laravel',
            'description' => 'Faire des tests unitaires',
            'status' => 'en_attente',
            'priorite' => 'moyenne',
            'date_echeance' => Carbon::today()->addDays(7)->format('Y-m-d'),
        ]);

        $response->assertRedirect(route('get.task'));

        $this->assertDatabaseHas('tasks', [
            'task' => 'Apprendre Laravel',
            'description' => 'Faire des tests unitaires',
            'status' => 'en_attente',
            'priorite' => 'moyenne',
            'date_echeance' => Carbon::today()->addDays(7)->format('Y-m-d'),
        ]);
    }

    /**
     * Vérifie que le titre est obligatoire.
     */
    public function test_le_titre_est_obligatoire(): void
    {

        $response = $this->post(route('save.task'), [
            'task' => '',
            'description' => 'Description de test',
            'status' => 'en_attente',
            'priorite' => 'moyenne',
            'date_echeance' => Carbon::today()->addDays(7)->format('Y-m-d'),
        ]);

        $response->assertSessionHasErrors('task');
    }

    /**
     * Vérifie qu'une tâche peut être modifiée.
     */
    public function test_un_utilisateur_peut_modifier_une_tache(): void
    {

        $task = Task::create([
            'task' => 'Ancien titre',
            'description' => 'Ancienne description',
            'status' => 'en_attente',
            'priorite' => 'faible',
            'date_echeance' => Carbon::today()->addDays(7)->format('Y-m-d'),
        ]);

        $response = $this->put(
            route('update.task', ['task' => $task->id]),
            [
                'task' => 'Nouveau titre',
                'description' => 'Nouvelle description',
                'status' => 'en_cours',
                'priorite' => 'elever',
                'date_echeance' => '2026-09-15',
            ]
        );

        $response->assertRedirect(route('get.task'));

        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'task' => 'Nouveau titre',
            'description' => 'Nouvelle description',
            'status' => 'en_cours',
            'priorite' => 'elever',
            'date_echeance' => '2026-09-15',
        ]);
    }

    /**
     * Vérifie qu'une tâche peut être supprimée.
     */
    public function test_un_utilisateur_peut_supprimer_une_tache(): void
    {
        $task = Task::create([
            'task' => 'Tâche à supprimer',
            'description' => 'Test suppression',
            'status' => 'en_attente',
            'priorite' => 'faible',
            'date_echeance' => Carbon::today()->addDays(7)->format('Y-m-d'),
        ]);

        $response = $this->delete(
            route('delete.task', ['task' => $task->id])
        );

        $response->assertRedirect(route('get.task'));

        $this->assertDatabaseMissing('tasks', [
            'id' => $task->id,
        ]);
    }
}
