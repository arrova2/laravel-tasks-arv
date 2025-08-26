<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Task;
use App\Models\User;

class TaskApiTest extends TestCase
{
    use RefreshDatabase;

    protected string $token = 'secreto-super';

    // protected function setUp(): void
    // {
    //     parent::setUp();
    //     config(['app.api_token' => $this->token]);
    // }

    protected function setUp(): void
    {
        parent::setUp();
        config([
            'app.api_token' => $this->token,
            'app.url'       => 'http://localhost',
        ]);
    }

    private function authHeaders(): array
    {
        return [
            'Authorization' => 'Bearer '.$this->token,
            'X-API-KEY'     => $this->token,
            'Accept'        => 'application/json',
            'HOST'          => 'localhost',
        ];
    }
    public function un_usuario_puede_crear_una_tarea_correctamente(): void
    {
        $user = User::factory()->create();

        $payload = [
            'title'       => 'Tarea importante',
            'description' => 'Descripción breve',
            'status'      => Task::STATUS_PENDING,
            'user_id'     => $user->id,
        ];

        // $res = $this->postJson('/api/tasks', $payload, $this->authHeaders());
        $res = $this->postJson('/api/tasks', $payload, $this->authHeaders());

        // $res->dump();

        $res->assertCreated()
            ->assertJsonFragment([
                'title'   => 'Tarea importante',
                'status'  => Task::STATUS_PENDING,
                'user_id' => $user->id,
            ]);

        $this->assertDatabaseHas('tasks', ['title' => 'Tarea importante']);
    }

    /** @test */
    public function no_se_puede_crear_una_tarea_con_datos_invalidos(): void
    {
        $payload = [
            'title'       => 'abc',
            'description' => str_repeat('x', 600),
            'status'      => 'invalid_status',
            'user_id'     => 9999,
        ];

        $res = $this->postJson('/api/tasks', $payload, $this->authHeaders());

        $res->assertStatus(422)
            ->assertJsonValidationErrors(['title','description','status','user_id']);
    }

    /** @test */
    public function una_tarea_puede_ser_eliminada_correctamente(): void
    {
        $task = Task::factory()->create();

        $res = $this->deleteJson('/api/tasks/'.$task->id, [], $this->authHeaders());

        $res->assertOk()->assertJson(['message' => 'Task deleted']);
        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }
}
