<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/auth/github/redirect', function () {
    return Socialite::driver('github')->redirect();
});
 
Route::get('/auth/github/callback', function () {
   
   try 
   {
    $socialiteUser = Socialite::driver('github')->user();
   } catch (\Exception $e) {
    return redirect ('/login');
   }

 
   $user = \App\Models\User::where(['provider' => 'github','provider_id' => $socialiteUser->getId()])->first();

   if(!$user)
   {
    $validator = \Illuminate\Support\Facades\Validator::make(
        ['email' => $socialiteUser->getEmail()],
        ['email' => ['unique:users,email']],       
    );
    
    if($validator->fails())
    {           
        return Inertia::render('Auth/Login', [
            'git_errors' => 'Ошибка входа! Возможно вы уже входили на сайт с использованием друго метода авторизации',
        ]);
    }
    
    
    $user = User::create([
            'name' => $socialiteUser->getNickname(),
            'email' => $socialiteUser->getEmail(),
            'provider' => 'github',
            'provider_id' => $socialiteUser->getId(),
            'email_verified_at' => now(),

        ]);

   }

   Auth::login($user);

   return redirect('/dashboard');
});



Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/auth.php';
