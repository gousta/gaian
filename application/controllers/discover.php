<?php

class Discover_Controller extends Base_Controller {


	public $restful = true;

	public function get_index()
	{

		$data['title'] = 'Discover Gaian Contributions';

		$data['data'] = DB::table('contributions')
		->order_by('timestamp', 'desc')
		->join('passports', 'contributions.author', '=', 'passports.id')
		->get(array('contributions.id', 'contributions.title', 'contributions.preview', 'contributions.category', 'passports.username', 'passports.first_name', 'passports.last_name'));

		return View::make('discover', $data);

	}

	public function get_category($value)
	{

		$data['title'] = 'Discover Gaian Contributions';

		$data['data'] = DB::table('contributions')
		->where('category', '=', $value)
		->order_by('timestamp', 'desc')
		->join('passports', 'contributions.author', '=', 'passports.id')
		->get(array('contributions.id', 'contributions.title', 'contributions.preview', 'contributions.category', 'passports.username', 'passports.first_name', 'passports.last_name'));

		return View::make('discover', $data);

	}

	public function get_contribution($category, $contID)
	{
		$data['user'] = Auth::user();
		$data['item'] = DB::table('contributions')
			->where('contributions.id', '=', $contID)
			->join('passports', 'contributions.author', '=', 'passports.id')
			->first(array(
				'contributions.id', 'contributions.author', 'contributions.title', 'contributions.description', 'contributions.tags', 'contributions.category','contributions.download',
				'passports.username', 'passports.first_name', 'passports.last_name', 'passports.avatar', 'passports.id as uid'));

		if($data['item'])
		{
			$data['comments'] = DB::table('comments')
				->where('section', '=', 'Contribution')->where('handler', '=', $contID)
				->order_by('timestamp', 'desc')
				->join('passports', 'comments.author', '=', 'passports.id')
				->get(array(
					'comments.id', 'comments.author', 'comments.comment', 'comments.timestamp',
					'passports.username', 'passports.first_name', 'passports.last_name', 'passports.avatar', 'passports.id as uid'));

			$data['related'] = DB::table('contributions')->where('author', '=', $data['item']->author)->order_by('timestamp', 'desc')->take(12)->get();
			$data['tags'] = explode(',', $data['item']->tags);

			$data['title'] = $data['item']->title.' on Gaian.me';


			return View::make('contribution', $data);
		} else {
			return Response::error('404');
		}
	}

	public function post_contribution($category, $contID)
	{
		if(Auth::check())
		{

			$data['input'] = array(
				'comment' => Input::get('comment')
			);

			$validation = Validator::make($data['input'], array('comment' => 'required'));

			if ($validation->fails())
			{
			  return Redirect::to('discover/'.$category.'/'.$contID)->with_errors($validation);
			} else {

				$data['user'] = Auth::user();
				$data['item'] = DB::table('contributions')->where('id', '=', $contID)->get();

				$insert = array(
					'id' => null,
					'section' => 'Contribution',
					'handler' => $contID,
					'author' => $data['user']->id,
					'timestamp' => time(),
					'comment' => $data['input']['comment'],
					'spam' => 0
				);

				DB::table('comments')->insert($insert);
			}
		}

		return Redirect::to('discover/'.$category.'/'.$contID);
	}

	public function get_contribution_edit($category, $contID)
	{
		if(Auth::check())
		{
			$data['item'] = DB::table('contributions')->where('id', '=', $contID)->first();
			$data['title'] = 'Edit: '.$data['item']->title.' on Gaian.me';

			if(Auth::user()->id == $data['item']->author)
			{
				return View::make('contribution-edit', $data);
			}
		}

		return Redirect::to('discover/'.$category.'/'.$contID);
	}

	public function post_contribution_edit($category, $contID)
	{
		if(Auth::check())
		{
			$item = DB::table('contributions')->where('id', '=', $contID)->first();

			if(Auth::user()->id == $item->author)
			{
				$validation = Validator::make(Input::all(), array('title' => 'required|max:80'));

				if ($validation->fails())
				{
				  return Redirect::to('discover/'.$category.'/'.$contID.'/edit')->with_errors($validation);
				} else {
					DB::table('contributions')->where('id', '=', $contID)->update(Input::all());
					return Redirect::to('discover/'.$contID)->with('success', 'Changes were saved successfully.');
				}
			}
		}

		return Redirect::to('discover/'.$category.'/'.$contID);
	}

	public function get_contribution_delete($category, $contID)
	{
		if(Auth::check())
		{
			$item = DB::table('contributions')->where('id', '=', $contID)->first();

			if(Auth::user()->id == $item->author)
			{
				DB::table('contributions')->delete($contID);
				DB::table('contribution_files')->where('handler', '=', $contID)->delete();

				$path = Config::get('path.media.path').$contID;

				if(file_exists($path))
				{
					File::rmdir($path);
				}
			}
		}

		return Redirect::to('discover');
	}

	public function get_commentdelete($category, $contID, $commentID)
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

		return Redirect::to('discover/'.$category.'/'.$contID);
	}

}

?>
