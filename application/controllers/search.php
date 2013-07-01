<?php

class Search_Controller extends Base_Controller {
	
	public $restful = true;
	
	public function get_index()
	{
		
		$data['query'] = Input::get('query');
		$data['title'] = 'Discover Gaian Contributions';		
		
		if ($data['query'] != '') {

			$data['contributions'] = DB::table('contributions')
            ->where('title', 'LIKE', '%'.$data['query'].'%')
            ->or_where('description', 'LIKE', '%'.$data['query'].'%')
            ->or_where('tags', 'LIKE', '%'.$data['query'].'%')
            ->or_where('category', 'LIKE', '%'.$data['query'].'%')
            ->order_by('timestamp', 'DESC')
            ->get();

			return View::make('search', $data);
		
		} else {
			
			return Redirect::to('discover');
		}
	   
	}
}
