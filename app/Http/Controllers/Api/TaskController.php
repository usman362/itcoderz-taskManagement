<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index(Request $request,$filter = null)
    {
        $tasks = Task::query();
        if(!empty($filter)){
            if($request->filter == 'completed'){
                $tasks->where('completed', 1);
            }elseif($request->filter == 'incomplete'){
                $tasks->where('completed', 0);
            }
        }
        $tasks = $tasks->get();
        return response()->json(['tasks'=>$tasks],200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
        ]);
        $task = Task::updateOrCreate(['id' => $request->task_id],
        ['title' => $request->title, 'description' => $request->description]);
        return response()->json(['message' => 'Task created/updated successfully'], 201);
    }

    public function edit(Task $task)
    {
        return response(['task' => $task],200);
    }

    public function update(Request $request, Task $task)
    {
        if(!empty($request->completed)){
            $task->update([
                'completed'=>$request->completed ? 1 : 0,
            ]);
        }

        return response()->json(['task'=>$task],201);
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return response()->json(['message'=>'Task has been Deleted'],200);
    }
}
