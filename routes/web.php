<?php

use Illuminate\Support\Facades\Route;

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
use App\Http\Controllers\EmployeeController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::group(["middleware" => ["auth"]], function () {
  Route::get('/custom-dashboard', function () {
    return view('custom');
  })->name('custom.dashboard');

  Route::get('/employee', [EmployeeController::class, 'index'])->name('employee.index');
  Route::get('/create-employee', [EmployeeController::class, 'create'])->name('employee.create');
  Route::post('/create-employee', [EmployeeController::class, 'store'])->name('employee.store');
  Route::get('/edit-employee/{id}', [EmployeeController::class, 'edit'])->name('employee.edit');
  Route::post('/edit-employee/{id}', [EmployeeController::class, 'update'])->name('employee.update');
  Route::get('/delete-employee/{id}', [EmployeeController::class, 'destroy'])->name('employee.delete');
});

require __DIR__.'/auth.php';
