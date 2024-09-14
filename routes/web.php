<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\AccessLogController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', ['canLogin' => TRUE]);
});

Route::get('/login', function () {
    return Inertia::render('Auth/Login');
});


Route::middleware(['auth'])->group(function () {
    Route::get('/employees-import', [EmployeeController::class, 'formImport'])->name('employees.formImport');
    Route::post('/employees-import', [EmployeeController::class, 'import'])->name('employees.import');

    Route::get('/employees/{employee}/history/download', [EmployeeController::class, 'downloadHistory'])->name('employees.history.download');



    Route::get('/employees', [EmployeeController::class, 'index'])->name('employees.index');
    Route::get('/employees/create', [EmployeeController::class, 'create'])->name('employees.create');
    Route::get('/employees/{employee}', [EmployeeController::class, 'history'])->name('employees.history');
    Route::get('/employees/edit/{employee}', [EmployeeController::class, 'edit'])->name('employees.edit');
    Route::post('/employees', [EmployeeController::class, 'store'])->name('employees.store');
    Route::put('/employees/{employee}', [EmployeeController::class, 'update'])->name('employees.update');
    Route::delete('/employees/{employee}', [EmployeeController::class, 'destroy'])->name('employees.destroy');
});
Route::post('/access-log', [AccessLogController::class, 'store'])->name('access_log.store');
Route::get('/room-911/{employee}', [RoomController::class, 'index'])->name('room');


require __DIR__.'/auth.php';
