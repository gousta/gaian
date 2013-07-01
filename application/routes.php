<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Simply tell Laravel the HTTP verbs and URIs it should respond to. It is a
| breeze to setup your application using Laravel's RESTful routing and it
| is perfectly suited for building large applications and simple APIs.
|
| Let's respond to a simple GET request to http://example.com/hello:
|
|		Route::get('hello', function()
|		{
|			return 'Hello World!';
|		});
|
| You can even respond to more than one URI:
|
|		Route::post(array('hello', 'world'), function()
|		{
|			return 'Hello World!';
|		});
|
| It's easy to allow URI wildcards using (:num) or (:any):
|
|		Route::put('hello/(:any)', function($name)
|		{
|			return "Welcome, $name.";
|		});
|
*/
/*
 |--------------------------------------------------------------------------
 | Paypal
 |--------------------------------------------------------------------------
 */
Route::post('secure/paypal/process', function()
{
    Bundle::start('paypal-ipn'); // Start Bundle
    $listener = new IpnListener(); // Instanciate IpnListener 
    $listener->use_sandbox = true; // PayPal Sandbox Acccount for testing
    $paypal_receiver = Config::get('application.paypal_receiver');
    
    try {
      $listener->requirePostMethod();
      $verified = $listener->processIpn();
    } catch (Exception $e) {
        Log::info($e->getMessage());
    }
    
    if ($verified) {
        // IPN response was "VERIFIED"
        
        $check = DB::table('transactions')->where('txn_id', '=', $_POST['txn_id'])->first();
        
    	if(!isset($check->txn_id))
    	{
    		if($_POST['payment_status'] == "Completed")
    		{// PAYMENT IS COMPLETED (NOT PENDING OR CHECK)
    			if($_POST['receiver_email'] == $paypal_receiver)
    			{// THE RECEIVER IS VALID
    				if($_POST['mc_currency'] == 'USD')
    				{// THE CURRENCY IS PROPER (DEFINED IS USD)
    					
    					switch($_POST['item_number'])
    					{
    						case 'RT50':  if($_POST['mc_gross'] != '10.00') { Log::info('PayPal: Recognised modified price; aborted.'); die(); } break;
    						case 'RT1500': if($_POST['mc_gross'] != '30.00'){ Log::info('PayPal: Recognised modified price; aborted.'); die(); } break;
    						case 'RT3000': if($_POST['mc_gross'] != '40.00'){ Log::info('PayPal: Recognised modified price; aborted.'); die(); } break;
    						case 'RT5000': if($_POST['mc_gross'] != '50.00'){ Log::info('PayPal: Recognised modified price; aborted.'); die(); } break;
    					}
                
                    	$data = array(
                    		'txn_id'=>$_POST['txn_id'],
                    		'custom'=>$_POST['custom'],
                    		'first_name'=>$_POST['first_name'],
                    		'last_name'=>$_POST['last_name'],
                    		'payer_email'=>$_POST['payer_email'],
                    		'payer_id'=>$_POST['payer_id'],
                    		'mc_currency'=>$_POST['mc_currency'],
                    		'mc_fee'=>$_POST['mc_fee'],
                    		'mc_gross'=>$_POST['mc_gross'],
                    		'residence_country'=>$_POST['residence_country'],
                    		'item_name'=>$_POST['item_name'],
                    		'item_number'=>$_POST['item_number'],
                    		'done_at'=>time(),
                    		'done_at_year'=>date('Y'),
                    		'done_at_month'=>date('n'),
                    		'complete'=>0
                    	);
                    	
                    	//Insert transaction to the database so that admin can process it.
                    	DB::table('transactions')->insert($data);
                    } else {
                        Log::info('PayPal: Recognised modified currency; aborted.');
                    }
                } else {
                    Log::info('PayPal: Recognised modified receiver; aborted.');
                }
            } else {
                Log::info('PayPal: Wrong payment status. Only processing -completed- transactions; aborted.');
            }
        } else {
            Log::info('PayPal: Transaction already processed txn_id: '.$_POST['txn_id'].'; aborted.');
        }
    } else {
        // IPN response was "INVALID"
        Log::info('PayPal: IPN responsed with -INVALID-. An Invalid IPN *may* be caused by a fraudulent transaction attempt; aborted.');
    }
});

Route::get('order-complete', function()
{
	return View::make('order');
});

Route::get('copyright', function()
{
		return View::make('copyright');
	
});

/*
 |--------------------------------------------------------------------------
 | USER
 |--------------------------------------------------------------------------
 */
Route::any('user/(:any)', 'user@profile');
Route::get('user/(:any)/c-(:num)/delete', 'user@commentdelete');

/*
 |--------------------------------------------------------------------------
 | SEARCH
 |--------------------------------------------------------------------------
 */
Route::any('search', 'search@index');

/*
 |--------------------------------------------------------------------------
 | SWARM
 |--------------------------------------------------------------------------
 
Route::any('swarm/(:any)', 'swarm@profile');
Route::get('swarm/(:any)/c-(:num)/delete', 'swarm@commentdelete');
Route::get('swarm/(:any)/edit', 'swarm@edit');
*/
/*
 |--------------------------------------------------------------------------
 | DISCOVER
 |--------------------------------------------------------------------------
 */
Route::any('discover/(:any)', 'discover@category');
Route::any('discover/(:any)/(:any)', 'discover@contribution');
Route::get('discover/(:any)/(:any)/c-(:num)/delete', 'discover@commentdelete');
Route::any('discover/(:any)/(:any)/edit', 'discover@contribution_edit');
Route::any('discover/(:any)/(:any)/delete', 'discover@contribution_delete');
Route::get('discover/(:any)/(:any)/download', function($category, $contID)
{
    if($contID)
    {
    	$file = DB::table('contribution_files')->where('handler', '=', $contID)->first();
	    return Response::download(Config::get('path.media.path').$contID.'/'.$file->filename);
    } else {
	    return Redirect::to('/');
    }
});

/*
 |--------------------------------------------------------------------------
 | FORUM
 |--------------------------------------------------------------------------
 */
Route::get('forum/(:any)', 'forum@forum');
Route::any('forum/(:any)/create', 'forum@create');
Route::any('forum/(:any)/(:any)', 'forum@topic');
Route::any('forum/(:any)/(:any)/edit', 'forum@edit');
Route::get('forum/(:any)/(:any)/lock', 'forum@lock');
Route::get('forum/(:any)/(:any)/unlock', 'forum@unlock');
Route::get('forum/(:any)/(:any)/delete', 'forum@delete');
Route::get('forum/(:any)/(:any)/c-(:num)/delete', 'forum@replydelete');
Route::get('forum/(:any)/(:any)/r-(:num)/delete', 'forum@replydelete');


/*
 |--------------------------------------------------------------------------
 | SIGN IN
 |--------------------------------------------------------------------------
 */
Route::get('sign-in', function()
{
	if(Auth::guest())
	{
		$data['nomenu'] = true;
		$data['title'] = 'Sign in to Gaian.me';
		return View::make('signin', $data);
	} else {
		return Redirect::to('/');
	}
});

Route::post('sign-in', function()
{
	if(Auth::guest())
	{
		$data['nomenu'] = true;
		$data['title'] = 'Sign in to Gaian.me';
		if(Input::get('email') and Input::get('password'))
		{
			$credentials = array('email' => Input::get('email'), 'password' => Input::get('password'), 'remember' => Input::get('remember'));
			
			if (Auth::attempt($credentials))
			{
				return Redirect::to(Request::referrer());
			} else {
				$data['error'] = 'Email or password is wrong.';
				return View::make('signin', $data);
			}
		} else {
			$data['error'] = 'Both fields are required.';
			return View::make('signin', $data);
		}
	} else {
		return Redirect::to('/');
	}
	
});

/*
 |--------------------------------------------------------------------------
 | JOIN
 |--------------------------------------------------------------------------
 */
Route::get('join', function()
{
	if(Auth::guest())
	{
		$data['title'] = 'Join our movement - Gaian.me';
		$data['gaians'] = DB::table('passports')->count();
		return View::make('join', $data);
	} else {
		return Redirect::to('/');
	}
});

Route::get('joined', function()
{
	$data['title'] = 'Thank you for joining Gaian.me';
	return View::make('joined', $data);
});

Route::post('join', function()
{
	$check = array(
		'email' => 'required|unique:passports|email',
		'username' => 'required|alpha_dash|between:2,30|unique:passports',
		'password' => 'required|between:5,30|confirmed',
		'first_name' => 'required'
	);

	$validation = Validator::make(Input::get(), $check);

	$resp = recaptcha_check_answer(
		Config::get('recaptcha.privatekey'),
		$_SERVER["REMOTE_ADDR"],
		Input::get('recaptcha_challenge_field'),
		Input::get('recaptcha_response_field')
	);

	if (!$resp->is_valid)
	{
		// What happens when the CAPTCHA was entered incorrectly
		die ("The reCAPTCHA wasn't entered correctly. Go back and try it again. (reCAPTCHA said: " . $resp->error . ")");
	}
	
	if ($validation->fails())
	{
		return Redirect::to('join')->with_errors($validation);
	} else {
		$data = Input::get();
		$activation = md5(time().$data['email']);
		
		//Prepare user data
		$newuser = array(
			'id'=> null,
			'fbid'=> null,
			'username'=> $data['username'],
			'password'=> md5($data['password']),
			'email'=> $data['email'],
			'first_name'=> $data['first_name'],
			'last_name'=> $data['last_name'],
			'social_status'=> 'Gaian Addict',
			'country'=> Utilities::country_code_to_country($_SERVER['HTTP_CF_IPCOUNTRY']),
			'city'=> '',
			'role'=> 0,
			'points'=> 0,
			'challenges'=> 0,
			'act_code'=> $activation,
			'stn'=> 1,
			'reg_date'=> time(),
			'timezone'=> '',
			'avatar'=> ''
		);
		
		DB::table('passports')->insert($newuser);
		
		$mail = new Mailer();
		$mail->setFrom('Gaian.me', 'mail@gaian.me');
		$mail->addRecipient(null, $data['email']);
		$mail->fillSubject('Gaian.me Account');
		$mail->fillMessage("Welcome to Gaian.me!\n\n".
												"We are very happy that you decided to join our community and we hope that you have a great time on our website.\n\n".
												"Please visit the following link to activate your account:\n".
												URL::to('activate/'.$activation)."\n\n".
												"Once you activate your account, you will be redirected to your account.\n\n".
												"We also have forums where fellow gaians hang out or ask for help installing themes, so you might want to check that out:\n".
												URL::to('forum')."\n\n".
												"Happy contributing!\n\n".
												"Best,\nThe Gaian.me Team");
		$mail->send();
		
			
		$data['title'] = 'Thank you for joining Gaian.me';
		return View::make('joined', $data);
	}
});

/*
 |--------------------------------------------------------------------------
 | ACTIVATE
 |--------------------------------------------------------------------------
 */
Route::get('activate/(:any)', function($hash)
{

	if($hash)
	{
		$user = DB::table('passports')->where('act_code', '=', $hash)->first();
		if($user->id)
		{
			DB::table('passports')->where('id', '=', $user->id)->update(array('role'=>1, 'act_code'=>null));
			
			Auth::login($user->id);
			
			return Redirect::to('user/'.$user->username);
		}
	}
	
	return Redirect::to('/');
});

/*
 |--------------------------------------------------------------------------
 | SIGN OUT
 |--------------------------------------------------------------------------
 */
Route::get('sign-out', function()
{
	Auth::logout();
	return Redirect::to('/');
});


Route::controller(Controller::detect());
/*
|--------------------------------------------------------------------------
| Application 404 & 500 Error Handlers
|--------------------------------------------------------------------------
|
| To centralize and simplify 404 handling, Laravel uses an awesome event
| system to retrieve the response. Feel free to modify this function to
| your tastes and the needs of your application.
|
| Similarly, we use an event to handle the display of 500 level errors
| within the application. These errors are fired when there is an
| uncaught exception thrown in the application.
|
*/

Event::listen('404', function()
{
	return Response::error('404');
});

Event::listen('500', function()
{
	return Response::error('500');
});

/*
|--------------------------------------------------------------------------
| Route Filters
|--------------------------------------------------------------------------
|
| Filters provide a convenient method for attaching functionality to your
| routes. The built-in before and after filters are called before and
| after every request to your application, and you may even create
| other filters that can be attached to individual routes.
|
| Let's walk through an example...
|
| First, define a filter:
|
|		Route::filter('filter', function()
|		{
|			return 'Filtered!';
|		});
|
| Next, attach the filter to a route:
|
|		Router::register('GET /', array('before' => 'filter', function()
|		{
|			return 'Hello World!';
|		}));
|
*/

Route::filter('before', function()
{
	// Do stuff before every request to your application...
});

Route::filter('after', function($response)
{
	// Do stuff after every request to your application...
});

Route::filter('csrf', function()
{
	if (Request::forged()) return Response::error('500');
});

Route::filter('auth', function()
{
	if (Auth::guest()) return Redirect::to('sign-in');
});

