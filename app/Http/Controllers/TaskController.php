<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Task;
use App\Models\User;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = User::find(2)->tasks()->orderBy('id', 'Desc')->get();

        return view('tasks.index', compact('tasks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = User::find(2)->categories;

        return view('tasks.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'string|max:255',
            'category_id' => 'required|integer|gte:1|exists:categories,id'
        ]);

        $validated['user_id'] = Auth::id();

        
        $task = Task::create($validated);

        return response()->json([ 
            'task' => $task,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        
        return view('tasks.show', compact('task'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        $categories = User::find(2)->categories;

        return view('tasks.edit', compact('task', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        $task->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $task->delete();
    }
}
