<?php

use App\Http\Controllers\TaskStatusController;
use Illuminate\Support\Facades\Auth;
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

Route::get('/', function (): \Illuminate\Contracts\View\View {
    return view('welcome');
})->name('welcome');


Auth::routes();

Route::resources([
    'task_statuses' => TaskStatusController::class,
]);
