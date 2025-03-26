<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\ResetPassword;
use App\Http\Controllers\ChangePassword;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ProfileController;

// Redirect root to dashboard if authenticated
Route::get('/', function () {
    return redirect('/dashboard');
})->middleware('auth');

// Authentication Routes
Auth::routes();

// Dashboard (Protected)
Route::get('/dashboard', [HomeController::class, 'index'])->name('home')->middleware('auth');

// Grouping Authenticated Routes
Route::middleware(['auth'])->group(function () {
    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
    
    // Dynamic Page Handler
    Route::get('/{page}', [PageController::class, 'index'])->name('page')->where('page', 'virtual-reality|rtl');
    
    // Logout Route (POST for Security)
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    
    // Items Management Routes
    Route::middleware(['permission:create-items|edit-items|delete-items'])->group(function () {
        Route::resource('items', ItemController::class)->except(['index', 'show']);
    });
    
    // Item view routes - accessible by all users
    Route::get('/items/export', [ItemController::class, 'export'])->name('items.export');
    Route::get('/items', [ItemController::class, 'index'])->name('items.index');
    Route::get('/items/{item}', [ItemController::class, 'show'])->name('items.show');
    
    // Inventory & Transaction Management Routes
    Route::middleware(['permission:view-inventory|view-transactions'])->group(function () {
        // Specific inventory routes first
        Route::get('/inventory/export', [InventoryController::class, 'export'])->name('inventory.export');
        Route::post('/inventory/import', [InventoryController::class, 'import'])->name('inventory.import');
        Route::get('/inventory/template', [InventoryController::class, 'downloadTemplate'])->name('inventory.template');
        
        // Then the resource and other specific routes
        Route::resource('inventory', InventoryController::class);
        Route::get('/inventory/{inventory}', [InventoryController::class, 'show'])->name('inventory.show');
        
        // Stock Management
        Route::get('/offhand/{item}', [InventoryController::class, 'offhandForm'])->name('inventory.offhand.form');
        Route::post('/offhand/{item}', [InventoryController::class, 'processOffhand'])->name('inventory.offhand.process');
        
        // Transaction Management
        Route::resource('transactions', TransactionController::class)->except(['edit', 'update', 'destroy']);
    });
    
    // Admin Only Routes
    Route::middleware(['role:admin|super-admin'])->group(function () {
        // Role Management
        Route::resource('roles', RoleController::class);
        
        // User Management
        Route::resource('users', UserController::class)->parameters(['users' => 'user']);
    });

    // User Management Routes
    Route::middleware(['permission:view-users'])->group(function () {
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
    });
    
    Route::middleware(['permission:create-users'])->group(function () {
        Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
    });
    
    Route::middleware(['permission:edit-users'])->group(function () {
        Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    });
    
    Route::middleware(['permission:delete-users'])->group(function () {
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    });

    // Role Management Routes
    Route::middleware(['permission:view-roles'])->group(function () {
        Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');
        Route::get('/roles/{role}', [RoleController::class, 'show'])->name('roles.show');
    });
});

// Auth Pages (Guest Only)
Route::middleware(['guest'])->group(function () {
    Route::get('/register', [RegisterController::class, 'create'])->name('register');
    Route::post('/register', [RegisterController::class, 'store'])->name('register.perform');
    Route::get('/login', [LoginController::class, 'show'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.perform');
    
    // Password Reset
    Route::get('/reset-password', [ResetPassword::class, 'show'])->name('reset-password');
    Route::post('/reset-password', [ResetPassword::class, 'send'])->name('reset.perform');
    Route::get('/change-password', [ChangePassword::class, 'show'])->name('change-password');
    Route::post('/change-password', [ChangePassword::class, 'update'])->name('change.perform');
});

Route::get('/', [App\Http\Controllers\HomeController_new::class, 'index'])->name('home');