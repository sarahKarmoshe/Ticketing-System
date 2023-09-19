<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\EvaluationController;
use App\Http\Controllers\PriorityController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\TechnicianController;
use App\Http\Controllers\TicketController;
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

Route::prefix('Admin')->group(function () {

    Route::post('signUp', [AdminController::class, 'signUp']);
    Route::post('login', [AdminController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('logout', [AdminController::class, 'logout']);

        //client
        Route::apiResource('client', ClientController::class);

        //category
        Route::apiResource('category', CategoryController::class);

        //service
        Route::apiResource('service', ServiceController::class);

        //status
        Route::apiResource('status',StatusController::class);

        //priority
        Route::apiResource('priority',PriorityController::class);

        //technician
        Route::apiResource('technician', TechnicianController::class);

        //Evaluation
        Route::apiResource('evaluation',EvaluationController::class);

        //Ticket
        Route::apiResource('ticket', TicketController::class)->only(['index', 'show', 'destroy']);
        Route::put('ticket/activate/{ticket}', [TicketController::class, 'activate']);
        Route::put('ticket/complete/{ticket}', [TicketController::class, 'complete']);


    });
});


Route::prefix('Client')->group(function () {

    Route::post('login', [ClientController::class, 'login']);

    //service
    Route::apiResource('service', ServiceController::class)->only(['index']);


    Route::middleware('auth:sanctum')->group(function () {
        Route::post('logout', [ClientController::class, 'logout']);

        //Evaluation
        Route::apiResource('evaluation',EvaluationController::class)->only(['index']);

        //Ticket
        Route::prefix('ticket')->group(function (){

            Route::post('',[TicketController::class,'store']);
            Route::put('/evaluate/{ticket}',[TicketController::class,'evaluate']);
            Route::get('',[TicketController::class,'indexClient']);
            Route::get('/{ticket}',[TicketController::class,'showClient']);

        });

    });

});
