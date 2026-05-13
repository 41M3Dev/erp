<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SalaireController;
use App\Http\Controllers\CongeController;
use App\Http\Controllers\AbsenceController;
use App\Http\Controllers\FinanceController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StatistiqueEmployeController;
use App\Http\Controllers\StatistiqueFinanceController;
use App\Http\Controllers\StatistiqueStockController;
use App\Http\Controllers\StatistiqueLivraisonController;
use App\Http\Controllers\StatistiqueRhController;
use App\Http\Controllers\StatistiqueFournisseurController;
use App\Http\Controllers\StatistiquePlanningController;
use App\Http\Controllers\StatistiqueDashboardController;

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('salaires', SalaireController::class)->names('api.salaires');
    Route::apiResource('conges', CongeController::class)->names('api.conges');
    Route::apiResource('absences', AbsenceController::class)->names('api.absences');
    Route::apiResource('transactions', FinanceController::class)->names('api.transactions')->middleware('role:manager');
    Route::get('user', function () {
        return response()->json(auth()->user());
    });

    Route::get('/users', [UserController::class, 'index'])->middleware('role:admin');
    Route::prefix('statistiques')->group(function () {
        Route::get('/employes', [StatistiqueEmployeController::class, 'index']);
        Route::get('/finances', [StatistiqueFinanceController::class, 'index']);
        Route::get('/stocks', [StatistiqueStockController::class, 'index']);
        Route::get('/livraisons', [StatistiqueLivraisonController::class, 'index']);
        Route::get('/rh', [StatistiqueRhController::class, 'index']);
        Route::get('/fournisseurs', [StatistiqueFournisseurController::class, 'index']);
        Route::get('/planning', [StatistiquePlanningController::class, 'index']);
        Route::get('/dashboard', [StatistiqueDashboardController::class, 'index']);
    });

});
