<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\cuentas;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/cuenta';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $numero= '4321';
        $clave = '';
        for($i = 1; $i <= 12; $i++){
            $numero = $numero . rand( 0 , 9 );
         }

        for($i = 0; $i < 3; $i++ ){
            $clave = $clave . rand(0, 9);
        }
        $mes = rand(1,12);
        $yy = rand(20,24);
        $valor = cuentas::create([
            'numerocuenta' => $numero,
            'dinero' => 10000,
            'usersid' => $user->id,
            'tipocuentaid' => 1,
            'deleted' => False,
            'clave' => $clave,
            'mes' => $mes,
            'anu' => $yy,
        ]);

         return $user;
    }
    
}
