<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $tasks = Task::where("user_id", $request->user()->id)
            ->when($request->status, fn ($query, $status) => $query->where("status", $status))
            ->when($request->priority, fn ($query, $priority) => $query->where("priority", $priority))
            ->orderByDesc("created_at")
            ->paginate(15);

        return response()->json($tasks);
    }

    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            "title" => "required|string|max:255",
            "description" => "nullable|string",
            "status" => "sometimes|in:pending,in_progress,completed,cancelled",
            "priority" => "sometimes|integer|min:1|max:3",
            "due_date" => "nullable|date",
            "tags" => "nullable|array",
        ]);

        if ($validator->fails()) {
            return response()->json(["errors" => $validator->errors()], 422);
        }

        $task = Task::create([
            ...$validator->validated(),
            "user_id" => $request->user()->id,
        ]);

        return response()->json(["data" => $task, "message" => "Tarea creada exitosamente"], 201);
    }

    public function show(Request $request, string $id): JsonResponse
    {
        $task = Task::where("id", $id)
            ->where("user_id", $request->user()->id)
            ->first();

        if (!$task) {
            return response()->json(["message" => "Tarea no encontrada"], 404);
        }

        return response()->json(["data" => $task]);
    }

    public function update(Request $request, string $id): JsonResponse
    {
        $task = Task::where("id", $id)
            ->where("user_id", $request->user()->id)
            ->first();

        if (!$task) {
            return response()->json(["message" => "Tarea no encontrada"], 404);
        }

        $validator = Validator::make($request->all(), [
            "title" => "sometimes|string|max:255",
            "description" => "nullable|string",
            "status" => "sometimes|in:pending,in_progress,completed,cancelled",
            "priority" => "sometimes|integer|min:1|max:3",
            "due_date" => "nullable|date",
            "tags" => "nullable|array",
        ]);

        if ($validator->fails()) {
            return response()->json(["errors" => $validator->errors()], 422);
        }

        $data = $validator->validated();
        
        if (isset($data["status"]) && $data["status"] === "completed" && !$task->completed_at) {
            $data["completed_at"] = now();
        }

        $task->update($data);

        return response()->json(["data" => $task, "message" => "Tarea actualizada exitosamente"]);
    }

    public function destroy(Request $request, string $id): JsonResponse
    {
        $task = Task::where("id", $id)
            ->where("user_id", $request->user()->id)
            ->first();

        if (!$task) {
            return response()->json(["message" => "Tarea no encontrada"], 404);
        }

        $task->delete();

        return response()->json(["message" => "Tarea eliminada exitosamente"]);
    }
}
