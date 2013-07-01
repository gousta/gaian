<?php namespace Laravel\Auth\Drivers;

use Laravel\Hash;
use Laravel\Config;
use Laravel\Database as DB;

class Fluent extends Driver {

	/**
	 * Get the current user of the application.
	 *
	 * If the user is a guest, null should be returned.
	 *
	 * @param  int         $id
	 * @return mixed|null
	 */
	public function retrieve($id)
	{
		if (filter_var($id, FILTER_VALIDATE_INT) !== false)
		{
			return DB::table('passports')->find($id);
		}
	}

	/**
	 * Attempt to log a user into the application.
	 *
	 * @param  array  $arguments
	 * @return void
	 */
	public function attempt($arguments = array())
	{
		$user = $this->get_user($arguments['email']);

		// This driver uses a basic username and password authentication scheme
		// so if the credentials match what is in the database we will just
		// log the user into the application and remember them if asked.

		if ( ! is_null($user) )
		{
			if(md5($arguments['password']) == $user->password)
			{
				return $this->login($user->id, array_get($arguments, 'remember'));
			}
		}

		return false;
	}

	/**
	 * Get the user from the database table by username.
	 *
	 * @param  mixed  $value
	 * @return mixed
	 */
	protected function get_user($value)
	{
		return DB::table('passports')->where('email', '=', $value)->first();
	}

}
