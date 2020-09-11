<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use APP\Task;

class TaskController extends Controller
{
    /*
     * @pathname: /tasks
     * @request: post
     * @response: json
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate(['title' => 'required']);

        $task = Task::create([
            'title' => $validatedData['title'],
            'project_id' => $request->project_id,
        ]);

        return $task->toJson();
    }

    /*
     * @pathname: /tasks/{task}
     * @request: put
     * @response: json
     */
    public function markAsCompleted(Task $task)
    {
        $task->is_completed = true;
        $task->update();

        return response()->json('Task updated!');
    }
}
