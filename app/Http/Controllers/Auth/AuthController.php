<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Auth;
use App\User;
use App\Clinic;
use App\Account;
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
            'street' => 'string|max:100',
            'clinic_id' => 'required'
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
        $clinic = Clinic::findOrFail($data['clinic_id']);

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
        $account = new Account([
            'clinic_id' => $clinic->clinic_id,
            'user_id' => $user->user_id,
        ]);
        $account->generatePK();
        $user->accounts()->save($account);

        return $user;
    }

    public function authenticated(Request $request, $user) 
    {
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

    protected function validateLogin(Request $request)
    {
        $this->validate($request, [
            $this->loginUsername() => 'required', 'password' => 'required', 'clinic_id' => 'required',
        ]);
    }

    public function login(Request $request)
    {
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        $throttles = $this->isUsingThrottlesLoginsTrait();

        if ($throttles && $lockedOut = $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        $credentials = $this->getCredentials($request);

        if (Auth::guard($this->getGuard())->attempt($credentials, $request->has('remember'))) {
            $account = Account::where('user_id', '=', $request->user_id)->where('clinic_id', '=', $request->clinic_id)->first();
            if($account === null) {
                auth()->logout();
                return redirect('/login')->with('warning', 'No estas registrado en esta clínica.');
            }
            session()->put('account_id', $account->account_id);
            return $this->handleUserWasAuthenticated($request, $throttles);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        if ($throttles && ! $lockedOut) {
            $this->incrementLoginAttempts($request);
        }

        return $this->sendFailedLoginResponse($request);
    }

    public function logout()
    {
        Auth::guard($this->getGuard())->logout();
        session()->forget('account_id');
        return redirect(property_exists($this, 'redirectAfterLogout') ? $this->redirectAfterLogout : '/');
    }

    public function register(Request $request) 
    {
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

    public function activate_user($token) 
    {
        if($user = $this->activationService->activateuser($token)) {
            return redirect('/login')->with('status', 'Se ha activado tu cuenta exitosamente, por favor incia sesión ahora.');
        }
        abort(404);
    }

    public function showRegistrationForm()
    {
        $clinics = Clinic::pluck('clinic_id', 'clinic_id');

        if (property_exists($this, 'registerView')) {
            return view($this->registerView);
        }

        return view('auth.register')->with('clinics', $clinics);
    }

    public function showLoginForm()
    {
        $view = property_exists($this, 'loginView')
                    ? $this->loginView : 'auth.authenticate';

        $clinics = Clinic::pluck('clinic_id', 'clinic_id');

        if (view()->exists($view)) {
            return view($view)->with('clinics', $clinics);
        }

        return view('auth.login')->with('clinics', $clinics);
    }
}
