<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $tasks = Task::query();

            if(!empty($request->completed)){
                $completed = $request->completed == 'completed' ? 1 : 0;
                $tasks->where('completed',$completed);
            }
            $tasks = $tasks->get();
            //filters end
            return DataTables::of($tasks)
                ->addColumn("status", function ($row) {
                    if($row->completed == true){
                        $status = '<span class="badge badge-success">Completed</span>';
                    }else{
                        $status = '<span class="badge badge-warning">Incomplete</span>';
                    }
                    return $status;
                })
                ->addColumn('action',function($row){
                    $checked = $row->completed == true ? 'checked' : '';
                    $edit = '<button class="btn btn-sm btn-icon edit-task" data-id="'.$row->id.'" tabindex="0"
                    aria-controls="DataTables_Table_0" type="button" data-bs-toggle="offcanvas"
                    data-bs-target="#offcanvasAddTask"><i class="bx bx-edit"></i></button>';
                    $delete = '<button class="btn btn-sm btn-icon delete-task" data-id="'.$row->id.'"><i class="bx bx-trash"></i></button>';
                    $completed = '<input type="checkbox" class="complete-task" data-id="'.$row->id.'" '.$checked.'>';
                    $action = '<div class="d-inline-block text-nowrap">'.$edit.$delete.$completed.'</div>';
                    return $action;
                })
                ->rawColumns(['status','action'])
                ->addIndexColumn()
                ->make();
        }
        $completedTasks = Task::where('completed',true)->count();
        $IncompletedTasks = Task::where('completed',false)->count();
        $totalTasks = Task::all()->count();
        return view('tasks.index',compact('completedTasks','IncompletedTasks','totalTasks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
        ]);
        $task = Task::updateOrCreate(['id' => $request->task_id],
        ['title' => $request->title, 'description' => $request->description]);
        return redirect(route('tasks.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        return response(['task' => $task],200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        if(!empty($request->completed)){
            $task->update([
                'completed'=>$request->completed ? 1 : 0,
            ]);
        }

        return response()->json(['task'=>$task],201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $task->delete();
        return response()->json(['message'=>'Task has been Deleted'],200);
    }
}
