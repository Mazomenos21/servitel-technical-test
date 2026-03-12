<?php

use App\Models\User;
use App\Models\Task;
use Laravel\Sanctum\Sanctum;

beforeEach(function () {
    $this->user = User::factory()->create();
    Sanctum::actingAs($this->user);
});

describe("Task API", function () {
    test("can list tasks", function () {
        Task::factory()->count(3)->create([
            "user_id" => $this->user->id,
        ]);

        $response = $this->getJson("/api/tasks");

        $response->assertStatus(200)
            ->assertJsonStructure([
                "data" => [
                    "*" => ["id", "title", "status", "priority"]
                ]
            ]);
    });

    test("can create a task", function () {
        $taskData = [
            "title" => "Mi primera tarea",
            "description" => "Descripcion de prueba",
            "status" => "pending",
            "priority" => 2,
        ];

        $response = $this->postJson("/api/tasks", $taskData);

        $response->assertStatus(201)
            ->assertJsonFragment(["title" => "Mi primera tarea"]);

        $this->assertDatabaseHas("tasks", ["title" => "Mi primera tarea"]);
    });

    test("can show a task", function () {
        $task = Task::factory()->create(["user_id" => $this->user->id]);

        $response = $this->getJson("/api/tasks/" . $task->id);

        $response->assertStatus(200);
    });

    test("can update a task", function () {
        $task = Task::factory()->create(["user_id" => $this->user->id]);

        $response = $this->putJson("/api/tasks/" . $task->id, ["title" => "Actualizado"]);

        $response->assertStatus(200);
    });

    test("can delete a task", function () {
        $task = Task::factory()->create(["user_id" => $this->user->id]);

        $response = $this->deleteJson("/api/tasks/" . $task->id);

        $response->assertStatus(200);
    });

    test("validates required fields", function () {
        $response = $this->postJson("/api/tasks", []);

        $response->assertStatus(422)->assertJsonValidationErrors(["title"]);
    });

    test("filters by status", function () {
        Task::factory()->create(["user_id" => $this->user->id, "status" => "pending"]);
        Task::factory()->create(["user_id" => $this->user->id, "status" => "completed"]);

        $response = $this->getJson("/api/tasks?status=pending");

        $response->assertJsonCount(1, "data");
    });

    test("unauthenticated returns 401", function () {
        $response = $this->getJson("/api/tasks");

        $response->assertStatus(401);
    });
});
