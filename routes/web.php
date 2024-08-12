<?php

use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// student
Route::post('/students', [StudentController::class, 'store'])->name('students.store');
Route::get('/students/{id}/edit', [StudentController::class, 'edit'])->name('students.edit');
Route::put('/students/{id}', [StudentController::class, 'update'])->name('students.update');
Route::delete('/students/{id}', [StudentController::class, 'destroy'])->name('students.destroy');
// teacher
// Route::get('teachers', [TeacherController::class, 'index'])->name('teachers.index');
Route::post('teachers', [TeacherController::class, 'store'])->name('teachers.store');
Route::put('teachers/{id}', [TeacherController::class, 'update'])->name('teachers.update');
Route::delete('teachers/{id}', [TeacherController::class, 'destroy'])->name('teachers.destroy');
Route::get('teachers/{id}/edit', [TeacherController::class, 'edit'])->name('teachers.edit');



Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', [TeacherController::class, 'index'])
        ->name('dashboard');
    Route::get('student', [StudentController::class, 'index'])->name('students.index');
});
