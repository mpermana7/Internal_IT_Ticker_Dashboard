<?php

use App\Http\Middleware\SetLocale;
use App\Livewire\Auth\Login;
use App\Livewire\CategoryManager;
use App\Livewire\DashboardOverview;
use App\Livewire\TicketDetail;
use App\Livewire\TicketManager;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Apply SetLocale Middleware
Route::middleware([SetLocale::class])->group(function () {

    // Switch Language Route
    Route::get('/lang/{locale}', function ($locale) {
        if (in_array($locale, ['id', 'en'])) {
            session(['locale' => $locale]);
            App::setLocale($locale);
        }
        return redirect()->back();
    })->name('lang.switch');

    // Guest Routes
    Route::middleware('guest')->group(function () {
        Route::get('/login', Login::class)->name('login');
    });

    // Authenticated Routes
    Route::middleware('auth')->group(function () {
        Route::get('/', DashboardOverview::class)->name('dashboard');
        Route::get('/tickets', TicketManager::class)->name('tickets.index');
        Route::get('/tickets/{id}', TicketDetail::class)->name('tickets.show');
        Route::get('/categories', CategoryManager::class)->name('categories.index');

        Route::any('/logout', function () {
            Auth::logout();
            session()->invalidate();
            session()->regenerateToken();
            return redirect()->route('login');
        })->name('logout');
    });
});
