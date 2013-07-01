<?php

class Load {

	public static function avatar($vset = null, $user = null, $size = 'thumb')
	{
		$PATH = Config::get('path.avatar.url');
		
		if(!$user) {
			$vset = Auth::user()->avatar;
			$user = Auth::user()->id;
		}
		
		if($vset == 'set')
		{
			return $PATH.$user.'/'.$size;
		} else {
			return $PATH.'default/'.$size;
		}
		
	}
	
}

?>