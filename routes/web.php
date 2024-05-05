<?php

use App\Http\Controllers\UserController;
use App\Models\User;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

Route::get('/', function () {
    return view('welcome');
});


Route::prefix('auth')->name('auth.')->group(function () {
    Route::get('redirect', function () {
        return Socialite::driver('google')->redirect();
    })->name('redirect');

    Route::get('callback', function () {
        $user = Socialite::driver('google')->stateless()->user();

        $user = User::updateOrCreate([
            'email' => $user->getEmail(),
        ], [
            'name' => $user->getName(),
        ]);

        auth()->login($user);

        return redirect()->route('user.index');
    })->name('callback');
});

Route::controller(UserController::class)
    ->name('user.')
    ->middleware('auth')
    ->prefix('user')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('logout', 'logout')->name('logout');
    });
