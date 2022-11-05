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

Route::get('/auth/{provider}/redirect', function ($provider) {
    return Socialite::driver($provider)->redirect();
})->where('provider', 'github|google|facebook');
 
Route::get('/auth/{provider}/callback', function ($provider) {
   
   try 
   {
    $socialiteUser = Socialite::driver($provider)->user();
   } catch (\Exception $e) {
    return redirect ('/login');
   }

  
   $user = \App\Models\User::where(['provider' => $provider,'provider_id' => $socialiteUser->getId()])->first();

   if(!$user)
   {
    $validator = \Illuminate\Support\Facades\Validator::make(
        ['email' => $socialiteUser->getEmail()],
        ['email' => ['unique:users,email']],       
    );
    
    if($validator->fails())
    {           
        return Inertia::render('Auth/Login', [
            'log_errors' => 'Login error! Mayby you have used another login method before?',
        ]);
    }
    
    if(!$socialiteUser->getName())
    {
        $name=$socialiteUser->getNickname();
    } else {
        $name = $socialiteUser->getName();
    }

    
    $user = User::create([
            'name' => $name,
            'email' => $socialiteUser->getEmail(),
            'provider' => $provider,
            'provider_id' => $socialiteUser->getId(),
            'email_verified_at' => now(),
        ]);

   }

   Auth::login($user);

   return redirect('/dashboard');
})->where('provider', 'github|google|facebook');



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
