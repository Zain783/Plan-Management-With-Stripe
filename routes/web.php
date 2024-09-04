<?php

use App\Http\Controllers\Admin\PlanController;
use App\Http\Controllers\User\PlanController as UserPlansController;


use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('admin/plans/store', [PlanController::class, 'store'])->name('admin.plans.store');
    Route::get('/plans/subscribe/{id}', [UserPlansController::class, 'subscribe'])->name('user.plans.subscribe');


    Route::get('stripe/{id}', [UserPlansController::class, 'stripe'])->name("plan.purchase");
    Route::post('stripe', [UserPlansController::class, 'stripePost'])->name('stripe.post');
});



require __DIR__ . '/auth.php';
