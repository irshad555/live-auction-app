<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\BidController;
use App\Http\Controllers\AuctionController;
use App\Http\Controllers\BidderDashboardController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminBidMonitorController;
use App\Http\Controllers\ChatController;
use Illuminate\Support\Facades\Route;

// Public
Route::get('/', function () {
    return view('welcome');
});

// Authenticated routes (common to both roles)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/chat/send', [ChatController::class, 'send'])->name('chat.send');
});

   



// routes/web.php

// Admin area
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'role:admin'])
    ->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::resource('products', ProductController::class)->except(['show', 'create']); 
        Route::get('/bids', [AdminBidMonitorController::class, 'index'])->name('bids.index');
        Route::get('/bids/monitor/{product}', [AdminBidMonitorController::class, 'monitor'])->name('bids.monitor');
        
    });

// Bidder area
Route::prefix('bidder')
    ->name('bidder.')
    ->middleware(['auth', 'role:bidder'])
    ->group(function () {
        Route::get('/dashboard', [BidderDashboardController::class, 'index'])->name('dashboard');
        Route::get('/auctions', [AuctionController::class, 'index'])->name('auctions.index');
        Route::get('/auctions/{auction}', [AuctionController::class, 'show'])->name('auctions.show');
        Route::post('/bids', [BidController::class, 'store'])->name('bids.store');
        // chat routes, notifications, etc.
    });



require __DIR__.'/auth.php';
