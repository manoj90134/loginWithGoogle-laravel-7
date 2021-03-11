<?php
namespace App\Http\Controllers\auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Socialite;
use Auth;
use Exception;
use App\User;
use Laravel\Socialite\Facades\Socialite as FacadesSocialite;


class GoogleController extends Controller
{

     /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function handleGoogleCallback()
    {
    //  $user= Socialite::driver('google')->stateless()->user();
    //  return $user->getName();

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
                'password' => encrypt('MOM_testing')

            ]);

            Auth::login($newUser);

            return redirect('/home');

        }

    } catch (Exception $e) {
        echo "Google Login Error";
        dd($e->getMessage());
    }

    }



}
