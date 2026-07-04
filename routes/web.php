<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\OutfitController;
use App\Http\Controllers\WardrobeController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\Outfit;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $outfits = Outfit::where('user_id', Auth::id())->get();
    return view('dashboard', compact('outfits'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Outfit resource (create, store, edit, update, destroy)
    Route::resource('outfits', OutfitController::class);

    // Wardrobe - menampilkan koleksi baju
    Route::get('/wardrobe', [WardrobeController::class, 'index'])->name('wardrobe');

    // Mix & Match - menampilkan kombinasi outfit
    Route::get('/mix-and-match', function () {
        $outfits = Outfit::where('user_id', Auth::id())->get();
        return view('mix-and-match', compact('outfits'));
    })->name('mix-and-match');
});

require __DIR__.'/auth.php';