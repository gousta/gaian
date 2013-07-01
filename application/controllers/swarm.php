<?php

class Swarm_Controller extends Base_Controller
{
	
	public $restful = true;
	
	public function get_index()
	{
		return Redirect::to('/');
	}
	
	public function get_profile($username)
	{
		$data['user'] = Auth::user();
		
		$data['swarm'] = DB::table('swarms')->where('custom_name', '=', $username)->first();
		
		if($data['swarm'])
		{
			$data['creator'] = DB::table('passports')->where('id', '=', $data['swarm']->creator)->first(array('id', 'username', 'first_name', 'last_name', 'avatar'));
			
			$data['comments'] = DB::table('comments')
				->where('section', '=', 'Swarm')->where('handler', '=', $data['swarm']->id)
				->order_by('timestamp', 'desc')
				->join('passports', 'comments.author', '=', 'passports.id')
				->get(array(
					'comments.id', 'comments.author', 'comments.comment', 'comments.timestamp',
					'passports.username', 'passports.first_name', 'passports.last_name', 'passports.avatar', 'passports.id as uid'));
			
			$data['gaiansnum'] = DB::table('swarm_members')->where('swarm_id', '=', $data['swarm']->id)->count();
			
			$data['gaians'] = DB::table('swarm_members')
				->where('swarm_members.swarm_id', '=', $data['swarm']->id)
				->take(18)
				->join('passports', 'swarm_members.member_id', '=', 'passports.id')
				->get(array('passports.username', 'passports.first_name', 'passports.last_name', 'passports.avatar', 'passports.id'));
			
			$data['title'] = $data['swarm']->name.' on Gaian.me';
			
			return View::make('swarm', $data);
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
			  return Redirect::to('swarm/'.$username)->with_errors($validation);
			} else {
			
				$data['user'] = Auth::user();
				$data['item'] = DB::table('swarms')->where('custom_name', '=', $username)->first();
				
				$insert = array(
					'id' => null,
					'section' => 'Swarm',
					'handler' => $data['item']->id,
					'author' => $data['user']->id,
					'timestamp' => time(),
					'comment' => $data['input']['comment'],
					'spam' => 0
				);
				
				DB::table('comments')->insert($insert);
			}
		}
		
		return Redirect::to('swarm/'.$username);
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
		
		return Redirect::to('swarm/'.$username);
	}
	
}