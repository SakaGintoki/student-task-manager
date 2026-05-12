<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Category;
use App\Http\Requests\StoreTaskRequest;
use App\Services\TaskPriorityService;
use App\Services\TaskValidationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    protected $priorityService;
    protected $validationService;

    public function __construct(TaskPriorityService $priorityService, TaskValidationService $validationService)
    {
        $this->priorityService = $priorityService;
        $this->validationService = $validationService;
    }

    public function index(Request $request)
    {
        $query = Auth::user()->tasks()->with('category')->latest();

        // Fitur Pencarian (Search)
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // Fitur Filter Status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $tasks = $query->paginate(10)->withQueryString();
        
        foreach ($tasks as $task) {
            $task->priority = $this->priorityService->calculateTaskPriority($task->deadline);
        }

        return view('tasks.index', compact('tasks'));
    }

    public function create()
    {
        $categories = Auth::user()->categories;
        return view('tasks.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validation = $this->validationService->validateTaskInput(
            $request->title, 
            $request->deadline, 
            $request->category_id ? (int)$request->category_id : null
        );

        if (!$validation['is_valid']) {
            return back()->withErrors($validation['errors'])->withInput();
        }

        Auth::user()->tasks()->create([
            'category_id' => $request->category_id,
            'title' => $request->title,
            'description' => $request->description,
            'deadline' => $request->deadline,
            'status' => 'Belum Dikerjakan',
        ]);

        return redirect()->route('tasks.index')->with('success', 'Tugas berhasil ditambahkan.');
    }

    public function show(Task $task)
    {
        $this->authorizeAccess($task);
        $task->priority = $this->priorityService->calculateTaskPriority($task->deadline);
        return view('tasks.show', compact('task'));
    }

    public function edit(Task $task)
    {
        $this->authorizeAccess($task);
        $categories = Auth::user()->categories;
        return view('tasks.edit', compact('task', 'categories'));
    }

    public function update(Request $request, Task $task)
    {
        $this->authorizeAccess($task);
        
        $validation = $this->validationService->validateTaskInput(
            $request->title, 
            $request->deadline, 
            $request->category_id ? (int)$request->category_id : null
        );

        if (!$validation['is_valid']) {
            return back()->withErrors($validation['errors'])->withInput();
        }

        $task->update([
            'category_id' => $request->category_id,
            'title' => $request->title,
            'description' => $request->description,
            'deadline' => $request->deadline,
        ]);

        return redirect()->route('tasks.index')->with('success', 'Tugas berhasil diperbarui.');
    }

    public function updateStatus(Request $request, Task $task)
    {
        $this->authorizeAccess($task);
        
        $request->validate([
            'status' => 'required|in:Belum Dikerjakan,Sedang Dikerjakan,Selesai',
        ]);

        $task->update(['status' => $request->status]);

        return back()->with('success', 'Status tugas berhasil diperbarui.');
    }

    public function destroy(Task $task)
    {
        $this->authorizeAccess($task);
        $task->delete();
        return redirect()->route('tasks.index')->with('success', 'Tugas berhasil dihapus.');
    }

    protected function authorizeAccess(Task $task)
    {
        if ($task->user_id !== Auth::id()) {
            abort(403);
        }
    }
}
