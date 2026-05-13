<?php
use App\Http\Controllers\FinanceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\EmployeController;
use App\Http\Controllers\CongeController;
use App\Http\Middleware\PermissionMiddleware;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SalaireController;
use App\Http\Controllers\FournisseurController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DashboardUtilisateurController;
use App\Http\Controllers\CommandeController;
use App\Http\Controllers\StockController;




Route::middleware('guest')->group(function () {
    Route::get('/', [LoginController::class, 'showLoginForm'])->name(name: 'login');
    Route::post('/', [LoginController::class, 'login']);
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function (): void {

    //CONGÉS
    Route::get('/conges/create', [CongeController::class, 'view_leave_request'])->name('conges.create');
    Route::post('/conges/create', [CongeController::class, 'leave_request'])->name('conges.create.store');
    // DASHBOARD

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/user/dashboard', [DashboardUtilisateurController::class, 'index'])->name('user.dashboard');
    Route::get('/user/edit/{id}', [DashboardUtilisateurController::class, 'edit'])->name('user.edit');
    Route::put('/user/update/{id}', [DashboardUtilisateurController::class, 'update'])->name('user.update');


    // FINANCES

    Route::middleware(PermissionMiddleware::class . ':superadmin,admin,finance')->group(function () {
        Route::prefix('finance')->group(function () {
            Route::get('/', [FinanceController::class, 'index'])->name('finances.index');
            Route::get('/create', [FinanceController::class, 'create'])->name('finances.create');
            Route::post('/', [FinanceController::class, 'store'])->name('finances.store');
            Route::get('/{id}/edit', [FinanceController::class, 'edit'])->name('finances.edit');
            Route::put('/{id}', [FinanceController::class, 'update'])->name('finances.update');
            Route::delete('/{id}', [FinanceController::class, 'destroy'])->name('finances.destroy');
        });

    });

    Route::middleware(PermissionMiddleware::class . ':superadmin,admin,finance,rh')->group(function () {

        // SALAIRES

        Route::prefix('salaires')->group(function () {
            Route::get('/', [SalaireController::class, 'index'])->name('salaires.index');
            Route::get('/create', [SalaireController::class, 'create'])->name('salaires.create');
            Route::post('/', [SalaireController::class, 'store'])->name('salaires.store');
            Route::get('/{id}/edit', [SalaireController::class, 'edit'])->name('salaires.edit');
            Route::put('/{id}', [SalaireController::class, 'update'])->name('salaires.update');
            Route::delete('/{id}', [SalaireController::class, 'destroy'])->name('salaires.destroy');
        });

    });

    // PERMISSIONS ADMIN

    Route::middleware(PermissionMiddleware::class . ':superadmin,admin')->group(function () {

        // PAGE GESTION UTILISATEURS
        Route::prefix('admin')->group(function () {
            Route::get('/', [AdminController::class, 'dashboard'])->name('admin.index');
            Route::get('/create', [AdminController::class, 'create'])->name('admin.create');
            Route::post('/', [AdminController::class, 'store'])->name('admin.store');
            Route::get('/{id}/edit', [AdminController::class, 'edit'])->name('admin.edit');
            Route::put('/{id}', [AdminController::class, 'update'])->name('admin.update');
            Route::delete('/{id}', [AdminController::class, 'destroy'])->name('admin.destroy');
        });

    });

    // PERMISSIONS RH

    Route::middleware(PermissionMiddleware::class . ':superadmin,admin,rh')->group(function () {

        //EMPLOYES
        Route::prefix('employes')->group(function () {
            Route::get('/', [EmployeController::class, 'index'])->name('employes.index');
            Route::get('/create', [EmployeController::class, 'create'])->name('employes.create');
            Route::post('/', [EmployeController::class, 'store'])->name('employes.store');
            Route::get('/{id}/edit', [EmployeController::class, 'edit'])->name('employes.edit');
            Route::put('/{id}', [EmployeController::class, 'update'])->name('employes.update');
            Route::delete('/{id}', [EmployeController::class, 'destroy'])->name('employes.destroy');
        });
        //GESTION DES DEMANDE DE CONGÉ
        Route::get('/conges', [CongeController::class, 'approval'])->name('conges.index');
        Route::post('/conges/{id}/approve', [CongeController::class, 'approveLeave'])->name('conges.approve');
        Route::post('/conges/{id}/reject', [CongeController::class, 'rejectLeave'])->name('conges.reject');
    });

    Route::middleware(PermissionMiddleware::class . ':superadmin,admin,manager,finance,livreur')->group(function () {

        // FOURNISSEURS
        Route::prefix('fournisseurs')->group(function () {
            Route::get('/', [FournisseurController::class, 'index'])->name('fournisseurs.index');
            Route::get('/create', [FournisseurController::class, 'create'])->name('fournisseurs.create');
            Route::post('/', [FournisseurController::class, 'store'])->name('fournisseurs.store');
            Route::get('/{fournisseur}/edit', [FournisseurController::class, 'edit'])->name('fournisseurs.edit');
            Route::put('/{fournisseur}', [FournisseurController::class, 'update'])->name('fournisseurs.update');
            Route::delete('/{fournisseur}', [FournisseurController::class, 'destroy'])->name('fournisseurs.destroy');
        });

        Route::prefix('commandes')->group(function () {
            Route::get('/', [CommandeController::class, 'index'])->name('commandes.index');
            Route::get('/create', [CommandeController::class, 'create'])->name('commandes.create');
            Route::post('/', [CommandeController::class, 'store'])->name('commandes.store');
            Route::get('/{commande}/edit', [CommandeController::class, 'edit'])->name('commandes.edit');
            Route::put('/{commande}', [CommandeController::class, 'update'])->name('commandes.update');
            Route::delete('/{commande}', [CommandeController::class, 'destroy'])->name('commandes.destroy');
        });

        Route::prefix('stocks')->group(function () {
            Route::get('/', [StockController::class, 'index'])->name('stocks.index');
            Route::get('/create', [StockController::class, 'create'])->name('stocks.create');
            Route::post('/', [StockController::class, 'store'])->name('stocks.store');
            Route::get('/{stock}/edit', [StockController::class, 'edit'])->name('stocks.edit');
            Route::put('/{stock}', [StockController::class, 'update'])->name('stocks.update');
            Route::delete('/{stock}', [StockController::class, 'destroy'])->name('stocks.destroy');
        });
    });

});