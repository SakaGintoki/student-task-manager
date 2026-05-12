<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Auth Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    Route::get('/dashboard', function () {
        $user = auth()->user();
        $taskCount = $user->tasks()->count();
        $completedTaskCount = $user->tasks()->where('status', 'Selesai')->count();
        $categoryCount = $user->categories()->count();
        
        // Data for charts
        $statusCounts = [
            'belum' => $user->tasks()->where('status', 'Belum Dikerjakan')->count(),
            'sedang' => $user->tasks()->where('status', 'Sedang Dikerjakan')->count(),
            'selesai' => $completedTaskCount
        ];
        
        return view('dashboard', compact('taskCount', 'completedTaskCount', 'categoryCount', 'statusCounts'));
    })->name('dashboard');

    // Category Routes
    Route::resource('categories', CategoryController::class);

    // Task Routes
    Route::resource('tasks', TaskController::class);
    Route::patch('/tasks/{task}/status', [TaskController::class, 'updateStatus'])->name('tasks.updateStatus');
});
