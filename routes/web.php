<?php

use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReceivableController;
use App\Http\Controllers\InstallmentController;
use App\Http\Controllers\GoalController;

Route::get('/', [DashboardController::class, 'index'])
    ->name('dashboard');

Route::resource('categories', CategoryController::class);

Route::resource('incomes', IncomeController::class);

Route::resource('expenses', ExpenseController::class);

Route::resource('receivables', ReceivableController::class);

Route::resource('installments', InstallmentController::class);

Route::patch(
    '/expenses/{expense}/pay',
    [ExpenseController::class, 'markAsPaid']
)->name('expenses.pay');


Route::patch(
    '/expenses/{expense}/pending',
    [ExpenseController::class, 'markAsPending']
)->name('expenses.pending');

Route::resource('goals', GoalController::class)
    ->only(['index', 'create', 'store', 'destroy']);

Route::post(
    '/goals/{goal}/deposit',
    [GoalController::class, 'deposit']
)->name('goals.deposit');

Route::post(
    '/goals/{goal}/withdraw',
    [GoalController::class, 'withdraw']
)->name('goals.withdraw');
