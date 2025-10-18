<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\LoginAdmin;
use App\Http\Controllers\admin\UsersAdmin;
use App\Http\Controllers\admin\DepositsAdmin;
use App\Http\Controllers\admin\ProductsAdmin;
use App\Http\Controllers\admin\SettingsAdmin;
use App\Http\Controllers\admin\DashboardAdmin;
use App\Http\Controllers\admin\WithdrawalsAdmin;
use App\Http\Controllers\admin\TransactionsAdmin;
use App\Http\Controllers\admin\LogAdmin;

Route::get('/login', [LoginAdmin::class, 'index'])->name('admin.login');
Route::post('/cek-login', [LoginAdmin::class, 'login'])->name('admin.cek-login');
Route::post('/logout', [LoginAdmin::class, 'logout'])->name('admin.logout');

Route::middleware(['cekLogin'])->group(function () {
    Route::get('/', action: [DashboardAdmin::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/dashboard', action: [DashboardAdmin::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/export-dashboard-excel', [DashboardAdmin::class, 'exportDashboardExcel'])->name('admin.dashboard.export-excel');


    Route::get('/admin/users', action: [UsersAdmin::class, 'index'])->name('admin.users');
    Route::get('/admin/export-pdf', action: [UsersAdmin::class, 'exportPDF'])->name('admin.export-pdf-view');
    Route::post('/admin/add-users', action: [UsersAdmin::class, 'addUsers'])->name('admin.add-users');
    Route::get('/admin/delete-user', [UsersAdmin::class, 'deleteUser'])->name('admin.delete-user');
    Route::post('/admin/edit-info-user/{id}', [UsersAdmin::class, 'editInfoUser'])->name('admin.edit-info-user');
    Route::post('/admin/edit-finance-user/{id}', [UsersAdmin::class, 'editFinanceUser'])->name('admin.edit-finance-user');
    Route::post('/admin/edit-wallet-user/{id}', [UsersAdmin::class, 'editWalletUser'])->name('admin.edit-wallet-user');
    Route::post('/admin/edit-boost-user/{id}', [UsersAdmin::class, 'editBoostUser'])->name('admin.edit-boost-user');
    Route::get('/admin/users/export/excel', [UsersAdmin::class, 'exportUsersExcel'])->name('admin.export-excel');
    Route::get('/admin/users/export/pdf', [UsersAdmin::class, 'exportUsersPdf'])->name('admin.export-pdf');

    Route::get('/admin/users-details', [UsersAdmin::class, 'detail'])->name('admin.users.detail');
    Route::post('/admin/reset-job', [UsersAdmin::class, 'resetJob'])->name('admin.reset-job');

    Route::get('/admin/products', [ProductsAdmin::class, 'index'])->name('admin.products');
    Route::post('/admin/add-products', [ProductsAdmin::class, 'addProducts'])->name('admin.add-products');
    Route::post('/admin/edit-products/{id}', [ProductsAdmin::class, 'editProducts'])->name('admin.edit-products');
    Route::post('/admin/delete-products/{id}', [ProductsAdmin::class, 'deleteProducts'])->name('admin.delete-products');

    Route::get('/admin/deposits', [DepositsAdmin::class, 'index'])->name('admin.deposits');
    Route::post('/admin/add-deposits', [DepositsAdmin::class, 'addDeposits'])->name('admin.add-deposits');
    Route::post('/admin/edit-deposits/{id}', [DepositsAdmin::class, 'editDeposits'])->name('admin.edit-deposits');
    Route::post('/admin/delete-deposits/{id}', [DepositsAdmin::class, 'deleteDeposits'])->name('admin.delete-deposits');

    Route::get('/admin/withdrawals', [WithdrawalsAdmin::class, 'index'])->name('admin.withdrawals');
    Route::post('/admin/add-withdrawals', [WithdrawalsAdmin::class, 'addWithdrawals'])->name('admin.add-withdrawals');
    Route::post('/admin/edit-withdrawals/{id}', [WithdrawalsAdmin::class, 'editWithdrawals'])->name('admin.edit-withdrawals');
    Route::post('/admin/delete-withdrawals/{id}', [WithdrawalsAdmin::class, 'deleteWithdrawals'])->name('admin.delete-withdrawals');
    Route::post('/admin/read-notifications', [WithdrawalsAdmin::class, 'readNotifications'])->name('admin.read-notifications');

    Route::get('/admin/transactions', [TransactionsAdmin::class, 'index'])->name('admin.transactions');
    Route::post('/admin/add-transactions', [TransactionsAdmin::class, 'addTransactions'])->name('admin.add-transactions');
    Route::post('/admin/edit-transactions/{id}', [TransactionsAdmin::class, 'editTransactions'])->name('admin.edit-transactions');
    Route::post('/admin/delete-transactions/{id}', [TransactionsAdmin::class, 'deleteTransactions'])->name('admin.delete-transactions');

    Route::get('/admin/log-admin', [LogAdmin::class, 'index'])->name('admin.log-admin');
    Route::get('/admin/settings', [SettingsAdmin::class, 'index'])->name('admin.settings');
    Route::post('/admin/update-settings', [SettingsAdmin::class, 'updateSettings'])->name('admin.settings-update');

});
