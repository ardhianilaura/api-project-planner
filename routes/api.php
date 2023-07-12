<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

use App\Http\Controllers\API\PlannerController;

Route::get('tasks', [PlannerController::class, 'index']);
Route::post('tasks', [PlannerController::class, 'store']);
Route::get('tasks/{id}', [PlannerController::class, 'show']);
Route::put('tasks/{id}', [PlannerController::class, 'update']);
Route::delete('tasks/{id}', [PlannerController::class, 'destroy']);
