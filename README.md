
Login WIth google with Socialite

Step 1: Install Laravel 7

composer global require laravel/installer

Composer create-project --prefer-dist laravel/laravel:7.0^  GmailLogin

Step 2: Install Socialite

composer require laravel/socialite

Add Alias or provider in Config file Inside Code. Now I am going to open onfig/app.php file and add service provider and alias.

'providers' => [
    ....
    Laravel\Socialite\SocialiteServiceProvider::class,
],

'aliases' => [
    ....
    'Socialite' => Laravel\Socialite\Facades\Socialite::class,
],

Step 3:  Create Auth for Login and register (Laravel automatic create Login and register pages)

terminal command :  composer require laravel/ui

terminal command :   php artisan ui:auth

terminal command :   php artisan ui bootstrap --auth

terminal command :   npm install & Npm run dev 

Step 4: Create Google App

link: http://console.developers.google.com/


Now you have to click on Credentials and choose first option oAuth and click Create new Client ID button. now you can see the following slide:

redirect id:  http://localhost:8000/auth/google/callback

client_id:??

client_secret:??

Add Google code in Config/service.php

Add clicnt id or secreate id in Config/service.php File

'google' => [
        'client_id' => 'app id',
        
        'client_secret' => 'add secret',
        
        'redirect' => 'http://localhost:8000/auth/google/callback',
    ],

Step 5: Add Database Column

terminal code:  Php artisan make:migration google_id_column

public function up()
    {
        Schema::table('users', function ($table) {
        
        $table->string('google_id')->nullable();
        
        });
    }
terminal: Php artsian migrate

Update User Model

Update user.php model File

protected $fillable = [
        
        'name', 'email', 'password', 'google_id'
    
    ];
    

routes/web.php


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('auth/google', 'Auth\GoogleController@redirectToGoogle');

Route::get('auth/google/callback', 'Auth\GoogleController@handleGoogleCallback');




Step 6: Create Controller


Terminal code:  php artisan make:controller auth/GoogleController


<?php

namespace App\Http\Controllers\Auth;
  
use App\Http\Controllers\Controller;

use Socialite;

use Auth;

use Exception;

use App\User;
  
class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
    
    return Socialite::driver('google')->redirect();
    
    }
    
    public function handleGoogleCallback()
    {
        try {   
     
     $user = Socialite::driver('google')->stateless()->user();
     
     $finduser = User::where('google_id', $user->id)->first();
     
     if($finduser){
     
     Auth::login($finduser);
     
     return redirect('/home');
     
     }else{
     $newUser = User::create([
           
           'name' => $user->name,
           
           'email' => $user->email,
           
           'google_id'=> $user->id,
           
           'password' => encrypt('Superman_test')
           
           ]);
           
           Auth::login($newUser);
           
           return redirect('/home');
           
           }
           
           } catch (Exception $e) {
           
           dd($e->getMessage());
        }
        
    }

}

?>


=========================================================================================

Step 7: Update Blade File

<a href="{{ url('auth/google') }}" style="margin-top: 20px;" class="btn btn-lg btn-success btn-block">
        
    <strong>Login With Google</strong>
                                </a> 

