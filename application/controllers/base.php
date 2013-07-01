<?php

class Base_Controller extends Controller {

	/**
	 * Catch-all method for requests that can't be matched.
	 *
	 * @param	string		$method
	 * @param	array			$parameters
	 * @return Response
	 */
	public function __call($method, $parameters)
	{
		return Response::error('404');
	}
			
	public function logRequest()
	{
		$route = Request::route();
		Log::log('request', "Controller: {$route->controller} / Action: {$route->controller_action} called at ". date('Y-m-d H:i:s'));
	}

}