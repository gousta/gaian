<?php

class Connect_Controller extends Base_Controller {
	
	/*
	|--------------------------------------------------------------------------
	| Index View
	|--------------------------------------------------------------------------
	*/
	public function action_index()
	{
		return Redirect::to('/');
	}
	
	/*
	|--------------------------------------------------------------------------
	| Index View
	|--------------------------------------------------------------------------
	*/
	public function action_facebook($callback = null)
	{
		$facebook = new Facebook(array(
			'appId'=> Config::get('facebook.appid'),
			'secret'=> Config::get('facebook.appsecret')
		));
		
		if($callback == 'callback')
		{
			if(Input::get('code'))
			{
				$token = $facebook->getAccessToken();
				$fb = $facebook->api('/me');
				
				if(Auth::check())
				{
					
					DB::table('passports')->where('id', '=', Auth::user()->id)->update(array('fbid'=>$fb['id']));
					
					return Redirect::to('settings/apps');
					
				} else {
					if($check = DB::table('passports')->where('fbid', '=', $fb['id'])->first(array('id', 'username')))
					{
						//Facebook ID matched a user in our DB. Log in the user
						Auth::login($check->id);
						
						return Redirect::to('user/'.$check->username);
					} else {
						
						//SET Session
						
						//Facebook ID DID NOT match a user in our DB. Save as a new member and generate a password to be sent in the email.
						//Generate random password for the user
						$randomPassword = Str::random(8);
						
						//Make sure the username is not taken. If it is, add 3 random numbers on the end of it.
						if(DB::table('passports')->where('username', '=', $fb['username'])->count() > 0)
						{
							$fb['username'] = $fb['username'].Str::random(3, 'num');
						}
						
						//Prepare user data
						$newuser = array(
							'id'=> null,
							'fbid'=> $fb['id'],
							'username'=> $fb['username'],
							'password'=> md5($randomPassword),
							'email'=> $fb['email'],
							'first_name'=> $fb['first_name'],
							'last_name'=> $fb['last_name'],
							'social_status'=> 'Gaian Addict',
							'country'=> Utilities::country_code_to_country($_SERVER['HTTP_CF_IPCOUNTRY']),
							'city'=> '',
							'role'=> 1,
							'points'=> 0,
							'challenges'=> 0,
							'stn'=> 1,
							'reg_date'=> time(),
							'timezone'=> '',
							'avatar'=> ''
						);
						
						//Save user data in Database
						$id = DB::table('passports')->insert_get_id($newuser);
						
						//Log in user
						Auth::login($id);
						
						//Send an email regarding the signup + let the user know of the password.
						$mail = new Mailer();
						$mail->setFrom('Gaian.me', 'mail@gaian.me');
						$mail->addRecipient(null, $newuser['email']);
						$mail->fillSubject('Gaian.me Account');
						$mail->fillMessage("Welcome to Gaian.me!\n\n".
															 "We are very happy that you decided to join our community and we hope that you have a great time on our website.\n\n".
															 "Since you signed up using facebook, we setup a password for you so you can also sign in using the simple Sign In form.\n".
															 "Your password is: ".$randomPassword."\n\n".
															 "However, you can always sign in using the facebook log in button.\n\n".
															 "We have forums where fellow gaians hang out or ask for help installing themes or customizing their computer in general, so you might want to check that out:\n".
															 URL::to('forum')."\n\n".
															 "Happy contributing!\n\n".
															 "Best,\nThe Gaian.me Team");
						$mail->send();
						
						return Redirect::to('user/'.$newuser['username']);
					}
				}
			} else {
				//CODE IS NOT SET
				return Redirect::to('/');
			}
		} else {
			$args = array(
				'scope'=> Config::get('facebook.scope'),
				'redirect_uri'=> URL::to(Config::get('facebook.redirectpath'))
			);
			$uri = $facebook->getLoginUrl($args);
			return Redirect::to($uri);
		}
	
	}

}