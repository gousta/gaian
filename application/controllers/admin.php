<?php

class Admin_Controller extends Base_Controller {
	
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
	
	/*
	|--------------------------------------------------------------------------
	| Index Controller
	|--------------------------------------------------------------------------
	*/
	public function get_index()
	{
		if(Auth::user()->role < 4) { return Redirect::to('/'); }
		
		//DB::query('SELECT COUNT(id) AS accounts FROM passports GROUP BY MONTH(FROM_UNIXTIME(reg_date,'%Y-%m-%d %H.%i.%s')), YEAR(FROM_UNIXTIME(reg_date,'%Y-%m-%d %H.%i.%s')) ORDER BY reg_date DESC');
		
		return Redirect::to('admin/dashboard');
	}
	
	/*
	|--------------------------------------------------------------------------
	| Dashboard
	|--------------------------------------------------------------------------
	*/
	public function get_dashboard()
	{
		if(Auth::user()->role < 4) { return Redirect::to('/'); }
		
		$data['page'] = 'dashboard';
		$data['title'] = 'Gaian Dashboard';
		
		return View::make('admin.dashboard', $data);
	}
	
	/*
	|--------------------------------------------------------------------------
	| Accounts
	|--------------------------------------------------------------------------
	*/
	public function get_passports($option = null, $parameter = null)
	{
		if(Auth::user()->role < 4) { return Redirect::to('/'); }
		
		$data['page'] = 'passports';
		$data['success'] = Session::get('success');
		
		switch($option)
		{
			case 'edit':
				$user = DB::table('passports')->where('id', '=', $parameter)->first();
				
				if($user->id)
				{
					$data['title'] = 'Edit Gaian: '.$user->username;
					$data['user'] = $user;
					
					return View::make('admin.passport-edit', $data);
				} else {
					return Redirect::to('admin/passports');
				}
				
			break;
			
			case 'delete':
				echo 'Not implemented yet.';
			break;
			
			default: 
				$data['title'] = 'Gaian Passports';
				$data['people'] = DB::table('passports')->paginate(12);
				
				return View::make('admin.passports', $data);
			break;
		}
	}
	
	public function post_passports($option = null, $parameter = null)
	{
		if(Auth::user()->role < 4) { return Redirect::to('/'); }
	
		if($option == 'edit')
		{
			$data = Input::all();
			
			DB::table('passports')->where('id', '=', $parameter)->update($data);
			
			return Redirect::to('admin/passports/edit/'.$parameter)->with('success', 'Saved!');
		}
		
		return Redirect::to('admin/passports/edit/'.$parameter);
	}
	
	/*
	|--------------------------------------------------------------------------
	| Contributions
	|--------------------------------------------------------------------------
	*/
	public function get_contributions($option = null, $parameter = null)
	{
		if(Auth::user()->role < 4) { return Redirect::to('/'); }
		
		$data['page'] = 'contributions';
		$data['success'] = Session::get('success');
		
		switch($option)
		{
			case 'feature':
				DB::table('contributions')->where('id', '=', $parameter)->update(array('featured'=>1));
				return Redirect::to(Request::referrer());
			break;
			
			case 'unfeature':
				DB::table('contributions')->where('id', '=', $parameter)->update(array('featured'=>0));
				return Redirect::to(Request::referrer());
			break;
			
			case 'edit':
				$contribution = DB::table('contributions')->where('id', '=', $parameter)->first();
				
				if($contribution->id)
				{
					$data['title'] = 'Edit Contribution: '.$contribution->title;
					$data['contribution'] = $contribution;
					
					return View::make('admin.contribution-edit', $data);
				} else {
					return Redirect::to('admin/contributions');
				}
				
			break;
			
			case 'delete':
				echo 'Not implemented yet.';
			break;
			
			default: 
				$data['title'] = 'Gaian Contributions';
				$data['contributions'] = DB::table('contributions')->order_by('timestamp', 'desc')->paginate(12);
				
				return View::make('admin.contributions', $data);
			break;
		}
	}
	
	public function post_contributions($option = null, $parameter = null)
	{
		if(Auth::user()->role < 4) { return Redirect::to('/'); }
	
		if($option == 'edit')
		{
			$data = Input::all();
			
			DB::table('contributions')->where('id', '=', $parameter)->update($data);
			
			return Redirect::to('admin/contributions/edit/'.$parameter)->with('success', 'Saved!');
		}
		
		return Redirect::to('admin/contributions/edit/'.$parameter);
	}
	
	/*
	|--------------------------------------------------------------------------
	| Forums
	|--------------------------------------------------------------------------
	*/
	public function get_forums($option = null, $category = null, $forum = null, $topic = null)
	{
		if(Auth::user()->role < 4) { return Redirect::to('/'); }
		
		$data['page'] = 'forums';
		$data['title'] = 'Gaian Forums';
		
		$data['_option'] = $option;
		$data['_category'] = $category;
		$data['_forum'] = $forum;
		$data['_topic'] = $topic;
		
		$data['forumcats'] = DB::table('forum_categories')->order_by('listing', 'asc')->get();
		
		if($category != '') {
			$data['c_category'] = DB::table('forum_categories')->where('forum_cat_id', '=', $category)->first();
			$data['forums'] = DB::table('forums')->where('forum_cat_id', '=', $category)->order_by('forum_id', 'desc')->get();
		}
		
		if($forum != '') {
			$data['c_category'] = DB::table('forum_categories')->where('forum_cat_id', '=', $category)->first();
			$data['c_forum'] = DB::table('forums')->where('forum_id', '=', $forum)->first();
			$data['topics'] = DB::table('forum_topics')->where('forum_id', '=', $forum)->get();
		}
		
		return View::make('admin.forums', $data);
	}
	
	public function post_forums($option = null, $category = null, $forum = null, $topic = null)
	{
		if(Auth::user()->role < 4) { return Redirect::to('/'); }
		
		$category_name = Input::get('category_name');
		$forum_name = Input::get('forum_name');
		
		if($forum_name != '')
		{
			$data = array(
				'forum_id'=>null,
				'forum_cat_id'=>$category,
				'name'=>$forum_name,
				'slug'=>Str::slug($forum_name)
			);
			
			DB::table('forums')->insert($data);
		}
		
		return Redirect::to(Request::referrer());
		
		
	}
	
	// END OF FILE
}