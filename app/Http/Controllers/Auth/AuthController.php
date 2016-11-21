<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\PersonalInformation;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request;
use App\ActivationService;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    protected $activationService;

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct(ActivationService $activationService)
    {
        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
        $this->activationService = $activationService;
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
            'user_id' => 'required|max:20',
            'email' => 'required|email|max:80|unique:personal_informations',
            'password' => 'required|min:6|confirmed',
            'name' => 'required|max:30',
            'last_name' => 'required|max:20',
            'mother_last_name' => 'required|max:20',
            'phone' => 'alpha_num',
            'street' => 'string|max:100'
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        $personal_information = new PersonalInformation([
            'name' => $data['name'],
            'last_name' => $data['last_name'],
            'mother_last_name' => $data['mother_last_name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'gender' => $data['gender'],
            'street' => $data['street'],
        ]);

        $user = User::create([
            'user_id' => $data['user_id'],
            'password' => bcrypt($data['password']),
        ]);

        $user->personal_information()->save($personal_information);

        return $user;
    }

    /**
     * Handle an authentication attempt.
     *
     * @return Response
     */
    public function authenticate()
    {
        if (Auth::attempt(['user_id' => $user_id, 'password' => $password])) {
            // Authentication passed...
            return redirect()->intended('dashboard');
        }
    }

    public function authenticated(Request $request, $user) {
        if(!$user->activated) {
            $this->activationService->sendActivationMail($user);
            auth()->logout();
            return back()->with('warning', 'Necesitas activar tu cuenta primero. Hemos enviado un enlace de activación a tu correo.');
        }

        return redirect()->intended($this->redirectPath());
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function loginUsername()
    {
        return property_exists($this, 'username') ? $this->username : 'user_id';
    }

    public function register(Request $request) {
        $validator = $this->validator($request->all());

        if($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }

        $user = $this->create($request->all());

        $this->activationService->sendActivationMail($user);
        return redirect('/login')->with('status', 'Te hemos enviado un enlace de activación. Revisa tu correo.');
    }

    public function activate_user($token) {
        if($user = $this->activationService->activateuser($token)) {
            auth()->login($user);
            return redirect($this->redirectPath());
        }
        abort(404);
    }
}
