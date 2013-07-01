<?php

class Api_Controller extends Base_Controller {

	public $restful = true;

	public function get_index()
	{
		return Redirect::to('/');
	}
	
	public function get_get($service = null)
	{
		
		switch($service)
		{
			case 'instagram': $found = 0;
			
				$response = json_decode(Remote::fetch('https://api.instagram.com/v1/tags/gaianme/media/recent?count=20&client_id=db10a08f71f447bd8dcf26e7d82ca113'), true);
				
				foreach($response['data'] as $item)
				{
					if(DB::table('feed_instagram')->where('id', '=', $item['id'])->count() == 0)
					{
						$data = array(
							'id'=>$item['id'],
							'link'=>$item['link'],
							'image'=>$item['images']['thumbnail']['url'],
							'user_username'=>$item['user']['username'],
							'user_website'=>$item['user']['website'],
							'user_bio'=>$item['user']['bio'],
							'user_picture'=>$item['user']['profile_picture'],
							'user_fullname'=>$item['user']['full_name'],
							'user_id'=>$item['user']['id'],
							'timestamp'=>time()
						);
						
						DB::table('feed_instagram')->insert($data);
						
					} else {
						$found++;
						
						if($found > 3) { break; }
					}
				}
			break;
			
			default: echo 'Invalid'; break;
		}
		
	}
	
	public function get_search()
	{
		$query = Input::get('query');
		$output = array();
		
		$users = DB::query("SELECT first_name, last_name, username FROM passports WHERE".
																	"   first_name LIKE ? ".
																	"OR last_name LIKE ? ".
																	"OR CONCAT(first_name, ' ', last_name) LIKE ? ".
																	"OR CONCAT(last_name, ' ', first_name) LIKE ? ",
																	
																	array($query.'%',$query.'%',$query.'%',$query.'%'));
		foreach($users as $user)
		{
			array_push($output, array(
				'title'=> $user->first_name.' '.$user->last_name,
				'url'=> URL::to('user/'.$user->username),
				'class'=> 'icon-cloud'
			));
		}
		
		
		return Response::json($output);
		
	}
	/*
	public function get_avatar($identifier = null, $size = 'normal')
	{
		if($identifier)
		{
			if($size == 'thumb' || $size == 'normal')
			{
				$return = Cache::remember('avatar_'.$identifier, function() use ($identifier)
				{
					$path = Config::get('path.avatar.url');
					$data = DB::table('passports')->where('id', '=', $identifier)->first(array('id', 'avatar'));
					
					if($data->avatar == 'set')
					{
						$user = $data->id;
					} else {
						$user = 'default';
					}
					
					return array(
						'thumb' => $path.$user.'/thumb',
						'normal' => $path.$user.'/normal',
					);
					
				}, 262974);
				
				return Redirect::to($return[$size]);
				
			} else {
				return Response::error('404');
			}
		} else {
			return Response::error('404');
		}
	}
	*/
	
}