<?php

namespace App\Providers;
use App\User; 
use Carbon\Carbon;
use Illuminate\Auth\GenericUser;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class CustomUserProvider implements UserProvider 
{

	/**
     * Retrieve a user by their unique identifier.
     *
     * @param  mixed  $identifier
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function retrieveById($identifier)
    {
        $query = User::where('user_id','=', $identifier);

		    if($query->count() > 0)
		    {
		        $user = $query->select('*')->first();

	         // 	$attributes = array(
		        //     'user_id' => $user->user_id,
		        //     'password' => $user->password,
		        //     'email' => $user->personal_information->email
		        // );

		        return $user;
		    }
		    return null;
    }

    /**
     * Retrieve a user by their unique identifier and "remember me" token.
     *
     * @param  mixed  $identifier
     * @param  string  $token
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function retrieveByToken($identifier, $token)
    {
        $query = User::where('user_id','=',$identifier)->where('remember_token', '=', $token);

		    if($query->count() > 0)
		    {
		        $user = $query->select('*')->first();

		        // $attributes = array(
		        //     'user_id' => $user->user_id,
		        //     'password' => $user->password,
		        //     'email' => $user->personal_information->email
		        // );
		        
		        return $user;
		    }
		    return null;
    }

    /**
     * Update the "remember me" token for the given user in storage.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @param  string  $token
     * @return void
     */
    public function updateRememberToken(Authenticatable  $user, $token)
    {
        $user->setRememberToken($token);

        $user->save();
    }

	/**
	 * Retrieve a user by the given credentials.
	 *
	 * @param  array $credentials
	 * @return \Illuminate\Contracts\Auth\Authenticatable|null
	 */
	public function retrieveByCredentials(array $credentials)
	{
			$query = null;
	    // TODO: Implement retrieveByCredentials() method.
			if(isset($credentials['email'])) {
				$query = User::join('personal_informations', 'users.user_id', '=', 'personal_informations.user_id')->where('email', '=', $credentials['email'])
				->select('users.*', 'personal_informations.email');
			} else {
				$query = User::where('user_id','=', $credentials['user_id'])->select('*');
			}

	    if($query->count() > 0)
	    {
	        $user = $query->first();
	        return $user;
	    }
	    return null;
	}

	/**
	 * Validate a user against the given credentials.
	 *
	 * @param  \Illuminate\Contracts\Auth\Authenticatable $user
	 * @param  array $credentials
	 * @return bool
	 */
	public function validateCredentials(Authenticatable $user, array $credentials)
	{
	    // TODO: Implement validateCredentials() method.
	    // we'll assume if a user was retrieved, it's good

	    // DIFFERENT THAN ORIGINAL ANSWER
	    // if(($user->user_id = $credentials['user_id'] || $user->personal_information->email == $credentials['email']) && Hash::check($credentials['password'], $user->getAuthPassword()))//$user->getAuthPassword() == md5($credentials['password'].\Config::get('constants.SALT')))
	    // {
	    //     return true;
	    // }
	    // return false;

			$plain = $credentials['password'];

    	return Hash::check($plain, $user->getAuthPassword());
	}

}