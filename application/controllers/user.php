<?php

class User_Controller extends Base_Controller
{
	
	public $restful = true;
	
	public function get_index()
	{
		return Redirect::to('/');
	}
	
	public function get_profile($username)
	{
		$data['user'] = Auth::user();
		$data['profile'] = DB::table('passports')->where('username', '=', $username)->first();
		
		if($data['profile'])
		{
			$data['top_activity'] = DB::first('SELECT COUNT(author) as total FROM comments GROUP BY author')->total;
			$data['user_activity'] = DB::first('SELECT COUNT(author) as total FROM comments WHERE author=? LIMIT 1', array($data['profile']->id))->total;
			if($data['user_activity'] == 0) { $data['user_activity'] = 1; }
			
			$data['comments'] = DB::table('comments')
				->where('section', '=', 'Passport')->where('handler', '=', $data['profile']->id)
				->order_by('timestamp', 'desc')
				->join('passports', 'comments.author', '=', 'passports.id')
				->get(array(
					'comments.id', 'comments.author', 'comments.comment', 'comments.timestamp',
					'passports.username', 'passports.first_name', 'passports.last_name', 'passports.avatar', 'passports.id AS uid'));
			
			$data['related'] = DB::table('contributions')->where('author', '=', $data['profile']->id)->order_by('timestamp', 'desc')->take(8)->get();
			
			$data['gaiansnum'] = DB::table('friendships')->where('friendships.id', '=', $data['profile']->id)->count();
				
			$data['gaians'] = DB::table('friendships')
				->where('friendships.id', '=', $data['profile']->id)
				->take(6)
				->join('passports', 'friendships.fid', '=', 'passports.id')
				->get(array('passports.username', 'passports.first_name', 'passports.last_name', 'passports.avatar', 'passports.id'));
				
			$data['swarmsnum'] = DB::table('swarms')->where('creator', '=', $data['profile']->id)->count();
			$data['swarms'] = DB::table('swarms')->where('creator', '=', $data['profile']->id)->take(6)->get();
			
			$data['title'] = $data['profile']->first_name.' '.$data['profile']->last_name.' on Gaian.me';
			
			return View::make('profile', $data);
		} else {
			return Response::error('404');
		}
		
	}
	
	public function post_profile($username)
	{
		if(Auth::check())
		{
			$data['input'] = array('comment' => Input::get('comment'));
			
			$validation = Validator::make($data['input'], array('comment' => 'required'));
			
			if ($validation->fails())
			{
				 return Redirect::to('user/'.$username)->with_errors($validation);
			} else {
			
				$data['user'] = Auth::user();
				$data['item'] = DB::table('passports')->where('username', '=', $username)->first();
				
				$insert = array(
					'id' => null,
					'section' => 'Passport',
					'handler' => $data['item']->id,
					'author' => $data['user']->id,
					'timestamp' => time(),
					'comment' => $data['input']['comment'],
					'spam' => 0
				);
				
				DB::table('comments')->insert($insert);
			}
		}
		
		return Redirect::to('user/'.$username);
	}
	
	public function get_commentdelete($username, $commentID)
	{
		if(Auth::check())
		{
				$data['user'] = Auth::user();
				$data['comment'] = DB::table('comments')->where('id', '=', $commentID)->first();
				
				if($data['user']->id == $data['comment']->author)
				{
					DB::table('comments')->where('id', '=', $commentID)->delete();
				}
		}
		
		return Redirect::to('user/'.$username);
	}
	
	public function get_edit($username)
	{
		echo 'Edit mode';
	}
	
}