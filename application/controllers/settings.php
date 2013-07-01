<?php

class Settings_Controller extends Base_Controller
{
	public $restful = true;
	
	/*
	|--------------------------------------------------------------------------
	| Construct Method
	|--------------------------------------------------------------------------
	*/
	public function __construct()
	{
		parent::__construct();
		
		//Must be logged in
		$this->filter('before', 'auth');
	}
	
	public function get_index()
	{
		return Redirect::to('settings/personal');
	}
	
	/*
	|--------------------------------------------------------------------------
	| Personal
	|--------------------------------------------------------------------------
	*/
	public function get_personal()
	{
		$data['user'] = Auth::user();
		$data['title'] = 'Personal Settings - Gaian.me';
		
		return View::make('settings.personal', $data);
	}
	
	public function post_personal()
	{
		DB::table('passports')->where('id', '=', Auth::user()->id)->update(Input::get());
		return Redirect::to('settings/personal');
	}
	
	/*
	|--------------------------------------------------------------------------
	| Regional
	|--------------------------------------------------------------------------
	*/
	public function get_regional()
	{
		$data['user'] = Auth::user();
		$data['title'] = 'Regional Settings - Gaian.me';
		
		return View::make('settings.regional', $data);
	}
	
	public function post_regional()
	{
		DB::table('passports')->where('id', '=', Auth::user()->id)->update(Input::get());
		return Redirect::to('settings/regional');
	}
	
	/*
	|--------------------------------------------------------------------------
	| Applications
	|--------------------------------------------------------------------------
	*/
	public function get_apps()
	{
		$data['user'] = Auth::user();
		$data['title'] = 'Applications Settings - Gaian.me';
		
		if($data['user']->fbid)
		{
			$data['fb'] = json_decode(Remote::fetch('http://graph.facebook.com/'.$data['user']->fbid));
		}
		
		return View::make('settings.apps', $data);
	}
	
	/*
	|--------------------------------------------------------------------------
	| Password
	|--------------------------------------------------------------------------
	*/
	public function get_password()
	{
		$data['user'] = Auth::user();
		$data['title'] = 'Password Settings - Gaian.me';
		
		return View::make('settings.password', $data);
	}
	
	public function post_password()
	{
		
		if(Auth::user()->password == md5(Input::get('current_password')))
		{
			$check = array(
				'password' => 'required|between:5,30|confirmed|different:current_password',
			);
			
			$validation = Validator::make(Input::get(), $check);
			
			if ($validation->fails())
			{
			  return Redirect::to('settings/password')->with_errors($validation);
			} else {
				DB::table('passports')->where('id', '=', Auth::user()->id)->update(array('password'=>md5(Input::get('password'))));
				return Redirect::to('settings/password')->with('good', 'Your new password is saved successfully.');
			}
		} else {
			return Redirect::to('settings/password')->with('bad', 'Your current password is wrong!');
		}
		
	}
	
	/*
	|--------------------------------------------------------------------------
	| Delete account
	|--------------------------------------------------------------------------
	*/
	public function get_delete()
	{
		$data['user'] = Auth::user();
		$data['title'] = 'Delete Account - Gaian.me';
		
		return View::make('settings.delete', $data);
	}
	
	public function post_delete()
	{
		if(Auth::user()->password == md5(Input::get('current_password')))
		{
			//Get user data
			$user = Auth::user();
			
			//Logout user
			Auth::logout();
			
			//Delete contributions
			foreach(DB::table('contributions')->where('author', '=', $user->id)->get() as $cont)
			{
				DB::table('contributions')->delete($cont->id);
				DB::table('contribution_files')->where('handler', '=', $contID)->delete();
				$path = Config::get('path.media').$cont->id;
				if(file_exists($path)) { File::rmdir($path); }
			}
			
			//Delete DRAFT contributions
			foreach(DB::table('draft_contributions')->where('author', '=', $user->id)->get() as $cont)
			{
				DB::table('draft_contributions')->delete($cont->id);
				DB::table('contribution_files')->where('handler', '=', $contID)->delete();
				$path = Config::get('path.media.path').$cont->id;
				if(file_exists($path)) { File::rmdir($path); }
			}
			
			//Delete celebrations
			DB::table('celebrations')->where('who', '=', $user->id)->delete();
			
			//Delete comments
			DB::table('comments')->where('author', '=', $user->id)->delete();
			
			//Delete engagements
			DB::table('engagements')->where('from', '=', $user->id)->or_where('belongs', '=', $user->id)->delete();
			
			//Delete notifications
			DB::table('notifications')->where('from', '=', $user->id)->or_where('belongs', '=', $user->id)->delete();
			
			//Delete forum topics
			DB::table('forum_topics')->where('author_id', '=', $user->id)->delete();
			
			//Delete forum posts
			DB::table('forum_topic_posts')->where('author_id', '=', $user->id)->delete();
			
			//Delete swarms
			DB::table('swarms')->where('creator', '=', $user->id)->delete();
			
			//Delete account
			DB::table('passports')->delete($user->id);
			
			//Redirect to start page.
			Redirect::to('/');
		} else {
			return Redirect::to('settings/delete')->with('bad', '<strong>Password</strong> is wrong.');
		}
	}
	
	public function get_avatar($delete = null)
	{
		if(Auth::check())
		{
			if($delete == 'delete')
			{
				$avatar = Auth::user()->avatar;
				if($avatar != '')
				{
					DB::table('passports')->where('id', '=', Auth::user()->id)->update(array('avatar'=>null));
					Cache::forget('avatar_'.Auth::user()->id);
					
					$path = Config::get('path.avatar.path').Auth::user()->id;
					
					/* Implementation of single folder containing all avatar sizes */
					if(file_exists($path))
					{
						File::rmdir($path);
					}
					
				}
			}
		}
		
		return Redirect::to('settings/personal');
	}
	
	public function post_avatar()
	{
		Bundle::start('resizer');
		
		$file = Input::file('file');
		
		$extension = strtolower(File::extension($file['name']));
		
		if($extension == 'jpeg' || $extension == 'jpg')
		{
			$path = Config::get('path.avatar.path').Auth::user()->id;
			$filename = 'original.jpg';
			
			if(!file_exists($path)) mkdir($path, 0777);
		
			Input::upload('file', $path, $filename);
			
			$path_to_file = $path.'/'.$filename;
			
			Resizer::open($path_to_file)->resize(50, 50, 'crop')->save($path.'/thumb.jpg');
			Resizer::open($path_to_file)->resize(180, 180, 'crop')->save($path.'/normal.jpg');
			
			DB::table('passports')->where('id', '=', Auth::user()->id)->update(array('avatar' => 'set'));
			
		} else {
			return Redirect::to('settings/personal')->with('error', 'Only JPEG images allowed.');
		}
		
		return Redirect::to('settings/personal');
	}
	
}