<?php

class Load_Controller extends Base_Controller {

	public $restful = true;
	
		
	public function get_gaians($user)
	{
		
		$data['gaians'] = DB::table('friendships')
			->where('friendships.id', '=', $user)
			->join('passports', 'friendships.fid', '=', 'passports.id')
			->get(array('passports.username', 'passports.first_name', 'passports.last_name', 'passports.avatar'));
		
		return View::make('load.gaians', $data);
	}
	
	
}