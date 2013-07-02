<?php

class Home_Controller extends Base_Controller {

	/*
	|--------------------------------------------------------------------------
	| The Default Controller
	|--------------------------------------------------------------------------
	|
	| Instead of using RESTful routes and anonymous functions, you might wish
	| to use controllers to organize your application API. You'll love them.
	|
	| This controller responds to URIs beginning with "home", and it also
	| serves as the default controller for the application, meaning it
	| handles requests to the root of the application.
	|
	| You can respond to GET requests to "/home/profile" like so:
	|
	|		public function action_profile()
	|		{
	|			return "This is your profile!";
	|		}
	|
	| Any extra segments are passed to the method as parameters:
	|
	|		public function action_profile($id)
	|		{
	|			return "This is the profile for user {$id}.";
	|		}
	|
	*/

	public function action_index()
	{
		$data['homepage'] = true;
		$data['title'] = 'Welcome to the Gaian Community';

		$data['celebrated'] = DB::table('contributions')
		->where('featured', '=', 1)
		->order_by('timestamp', 'desc')
		->join('passports', 'contributions.author', '=', 'passports.id')
		->get(array('contributions.id', 'contributions.title', 'contributions.preview', 'passports.username', 'passports.first_name', 'passports.last_name'));


		$data['feed'] = DB::table('feed_instagram')->order_by('timestamp', 'desc')->take(9)->get(); // change the number on 18, when it will be more images ;)

		return View::make('home', $data);
	}

}
