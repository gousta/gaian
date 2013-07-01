<?php

class Forum_Controller extends Base_Controller {
	
	public $restful = true;
	
	/*
	|--------------------------------------------------------------------------
	| Forums Overview
	|--------------------------------------------------------------------------
	*/
	public function get_index()
	{
	
		$data['title'] = 'Gaian Forums';
		
		$categories = DB::table('forum_categories')->order_by('listing', 'asc')->get();
		$list = DB::table('forums')->get();
		
		for($i=0; $i < count($list); $i++)
		{
			
			$tmp['activity'] = DB::table('forum_topic_posts')
				->where('forum_topic_posts.forum_id', '=', $list[$i]->forum_id)
				->order_by('timestamp', 'desc')
				->join('forum_topics', 'forum_topic_posts.topic_id', '=', 'forum_topics.topic_id')
				->join('passports', 'forum_topic_posts.author_id', '=', 'passports.id')
				->first(array('forum_topic_posts.author_id', 'forum_topic_posts.timestamp', 'forum_topics.name', 'forum_topics.slug', 'passports.first_name', 'passports.last_name'));
			
			$list[$i]->topic_count = DB::table('forum_topics')->where('forum_id', '=', $list[$i]->forum_id)->count();
			$list[$i]->post_count = DB::table('forum_topic_posts')->where('forum_id', '=', $list[$i]->forum_id)->count();
			$list[$i]->activity = $tmp['activity'];
			
			
			
			for($x=0; $x < count($categories); $x++)
			{
				if($categories[$x]->forum_cat_id == $list[$i]->forum_cat_id)
				{
					$data['forumdata'][$categories[$x]->name][] = $list[$i];
				}
			}
		}
		
		return View::make('forum.index', $data);
		
	}
	
	/*
	|--------------------------------------------------------------------------
	| Forum View
	|--------------------------------------------------------------------------
	*/
	public function get_forum($forum)
	{
		$data['forum'] = DB::table('forums')->where('slug', '=', $forum)->first();
		
		$data['topics'] = DB::table('forum_topics')->where('forum_id', '=', $data['forum']->forum_id)->order_by('timestamp', 'desc')->get(array('topic_id', 'author_id', 'name', 'slug', 'views', 'locked'));
		
		for($i=0; $i < count($data['topics']); $i++)
		{			
			$tmp['activity'] = DB::table('forum_topic_posts')
				->where('forum_topic_posts.topic_id', '=', $data['topics'][$i]->topic_id)
				->order_by('timestamp', 'desc')
				->join('passports', 'forum_topic_posts.author_id', '=', 'passports.id')
				->first(array('forum_topic_posts.post','forum_topic_posts.timestamp', 'passports.first_name', 'passports.last_name'));
			
			$data['topics'][$i]->replies = DB::table('forum_topic_posts')->where('topic_id', '=', $data['topics'][$i]->topic_id)->count();
			$data['topics'][$i]->author = DB::table('passports')->where('id', '=', $data['topics'][$i]->author_id)->first(array('first_name', 'last_name', 'username'));
			$data['topics'][$i]->activity = $tmp['activity'];
		}
		
		$data['title'] = $data['forum']->name.' - Gaian Forums';
		
		return View::make('forum.view', $data);
		
	}
	
	/*
	|--------------------------------------------------------------------------
	| Topic View
	|--------------------------------------------------------------------------
	*/
	public function get_topic($forum, $topic)
	{
		DB::table('forum_topics')->where('slug', '=', $topic)->increment('views');
		
		$data['user'] = Auth::user();
		
		$data['forum'] = DB::table('forums')->where('slug', '=', $forum)->first();
		
		$data['topic'] = DB::table('forum_topics')->where('slug', '=', $topic)->first();
		$data['topic']->author = DB::table('passports')->where('id', '=', $data['topic']->author_id)->first(array('id', 'first_name', 'last_name', 'username', 'avatar'));
		
		$data['posts'] = DB::table('forum_topic_posts')
				->where('topic_id', '=', $data['topic']->topic_id)
				->order_by('timestamp', 'desc')
				->join('passports', 'forum_topic_posts.author_id', '=', 'passports.id')
				->get(array('forum_topic_posts.post_id', 'forum_topic_posts.post', 'forum_topic_posts.timestamp', 'forum_topic_posts.author_id',
										'passports.first_name', 'passports.last_name', 'passports.username', 'passports.avatar', 'passports.id as uid'));
		
		$data['title'] = $data['topic']->name.' - '.$data['forum']->name.' - Gaian Forums';
		
		return View::make('forum.topic.index', $data);
	}
	
	/*
	|--------------------------------------------------------------------------
	| Topic Reply Engine
	|--------------------------------------------------------------------------
	*/
	public function post_topic($forum, $topic)
	{
		if(!Auth::check())
		{
			return Redirect::to('forum/'.$forum);
		}
		
		$data['user'] = Auth::user();
		$data['topic'] = DB::table('forum_topics')->where('slug', '=', $topic)->first();
		
		$data['input'] = array(
			'reply' => Input::get('reply')
		);
		
		$data['user'] = Auth::user();
		
		$validation = Validator::make($data['input'], array('reply' => 'required'));
		
		if ($validation->fails())
		{
		  return Redirect::to('forum/'.$forum.'/'.$topic)->with_errors($validation);
		} else {
			
			$insert = array(
				'post_id' => null,
				'topic_id' => $data['topic']->topic_id,
				'forum_id' => $data['topic']->forum_id,
				'author_id' => $data['user']->id,
				'post' => $data['input']['reply'],
				'timestamp' => time(),
				'spam' => 0
			);
			
			DB::table('forum_topic_posts')->insert($insert);
		}
		
		return Redirect::to('forum/'.$forum.'/'.$topic);
	}
	
	/*
	|--------------------------------------------------------------------------
	| Topic Create View
	|--------------------------------------------------------------------------
	*/
	public function get_create($forum)
	{
		if(!Auth::check())
		{
			return Redirect::to('forum/'.$forum);
		}
		
		$data['forum'] = DB::table('forums')->where('slug', '=', $forum)->first();
		
		$data['title'] = 'Add Topic - '.$data['forum']->name.' - Gaian Forums';
		
		return View::make('forum.topic.create', $data);
	}
	
	/*
	|--------------------------------------------------------------------------
	| Topic Create Engine
	|--------------------------------------------------------------------------
	*/
	public function post_create($forum)
	{
		if(!Auth::check())
		{
			return Redirect::to('forum/'.$forum);
		}
		
		$data['forum'] = DB::table('forums')->where('slug', '=', $forum)->first();
		
		$data['input'] = array(
			'topic' => Input::get('topic'),
			'content' => Input::get('content')
		);
		$rules = array(
			'topic' => 'required|max:80',
			'content' => 'required'
		);
		
		$data['user'] = Auth::user();
		
		$validation = Validator::make($data['input'], $rules);
		
		if ($validation->fails())
		{
		  return Redirect::to('forum/'.$forum.'/create')->with_errors($validation);
		} else {
		
			$id = DB::table('forum_topics')->max('topic_id') + 1;
			
			$insert = array(
				'topic_id' => $id,
				'forum_id' => $data['forum']->forum_id,
				'author_id' => $data['user']->id,
				'post' => $data['input']['content'],
				'name' => $data['input']['topic'],
				'slug' => Str::slug($data['input']['topic']).'-'.$id,
				'views' => 0,
				'timestamp' => time(),
				'attachment' => null,
				'locked' => 0
			);
			
			DB::table('forum_topics')->insert($insert);
			
			return Redirect::to('forum/'.$forum.'/'.$insert['slug']);
		}
		
	}
	
	/*
	|--------------------------------------------------------------------------
	| Topic Edit View
	|--------------------------------------------------------------------------
	*/
	public function get_edit($forum, $topic)
	{
		$data['forum'] = $forum;
		$data['user'] = Auth::user();
		$data['topic'] = DB::table('forum_topics')->where('slug', '=', $topic)->first();
		
		$data['title'] = 'Edit Topic - '.$data['topic']->name.' - Gaian Forums';
		
		if($data['user']->id == $data['topic']->author_id)
		{
			return View::make('forum.topic.edit', $data);
		} else {
			return Redirect::to('forum/'.$forum.'/'.$topic);
		}
	}
	
	/*
	|--------------------------------------------------------------------------
	| Topic Edit Engine
	|--------------------------------------------------------------------------
	*/
	public function post_edit($forum, $topic)
	{
		$data['user'] = Auth::user();
		$data['topic'] = DB::table('forum_topics')->where('slug', '=', $topic)->first();
		
		if($data['user']->id == $data['topic']->author_id)
		{
			$data['input'] = array(
				'topic' => Input::get('topic'),
				'content' => Input::get('content')
			);
			$rules = array(
				'topic' => 'required|max:80',
				'content' => 'required'
			);
			
			$data['user'] = Auth::user();
			
			$validation = Validator::make($data['input'], $rules);
			
			if ($validation->fails())
			{
			  return Redirect::to('forum/'.$forum.'/'.$topic.'/edit')->with_errors($validation);
			} else {
				
				$update = array(
					'post' => $data['input']['content'],
					'name' => $data['input']['topic'],
					'slug' => Str::slug($data['input']['topic']).'-'.$data['topic']->topic_id
				);
				
				DB::table('forum_topics')->where('topic_id', '=', $data['topic']->topic_id)->update($update);
			}
		}
		
		return Redirect::to('forum/'.$forum.'/'.$update['slug']);
	}
	
	/*
	|--------------------------------------------------------------------------
	| Topic Lock Engine
	|--------------------------------------------------------------------------
	*/
	public function get_lock($forum, $topic)
	{
		$data['user'] = Auth::user();
		$data['topic'] = DB::table('forum_topics')->where('slug', '=', $topic)->first();
		
		if($data['user']->id == $data['topic']->author_id)
		{
			DB::table('forum_topics')->where('slug', '=', $topic)->update(array('locked' => 1));
		}
		
		return Redirect::to('forum/'.$forum.'/'.$topic);
	}
	
	/*
	|--------------------------------------------------------------------------
	| Topic Unlock Engine
	|--------------------------------------------------------------------------
	*/
	public function get_unlock($forum, $topic)
	{
		$data['user'] = Auth::user();
		$data['topic'] = DB::table('forum_topics')->where('slug', '=', $topic)->first();
		
		if($data['user']->id == $data['topic']->author_id)
		{
			DB::table('forum_topics')->where('slug', '=', $topic)->update(array('locked' => 0));
		}
		
		return Redirect::to('forum/'.$forum.'/'.$topic);
	}
	
	/*
	|--------------------------------------------------------------------------
	| Topic Delete Engine
	|--------------------------------------------------------------------------
	*/
	public function get_delete($forum, $topic)
	{
		$data['user'] = Auth::user();
		$data['topic'] = DB::table('forum_topics')->where('slug', '=', $topic)->first();
		
		if($data['user']->id == $data['topic']->author_id)
		{
			DB::table('forum_topics')->where('slug', '=', $topic)->delete();
		}
		
		return Redirect::to('forum/'.$forum);
	}
	
	/*
	|--------------------------------------------------------------------------
	| Reply Delete Engine
	|--------------------------------------------------------------------------
	*/
	public function get_replydelete($forum, $topic, $reply)
	{
		$data['user'] = Auth::user();
		
		$data['reply'] = DB::table('forum_topic_posts')->where('post_id', '=', $reply)->first();
		
		if($data['user']->id == $data['reply']->author_id)
		{
			DB::table('forum_topic_posts')->where('post_id', '=', $reply)->delete();
		}
		
		return Redirect::to('forum/'.$forum.'/'.$topic);
	}
	

}


