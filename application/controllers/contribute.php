<?php

class Contribute_Controller extends Base_Controller
{
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
		
		if(Auth::check()) {
			$this->user = Auth::user();
			$this->draft = DB::table('draft_contributions')->where('author', '=', $this->user->id)->first();
			//if there is no draft, start one
			if(!$this->draft)
			{
				$data = array(
					'id' => Str::random(12),
					'status' => 0,
					'author' => $this->user->id,
					'updated_at' => DB::raw('NOW()'),
					'created_at' => DB::raw('NOW()'),
				);
				DB::table('draft_contributions')->insert($data);
				
				$this->draft = DB::table('draft_contributions')->where('author', '=', $this->user->id)->first();
			}
		}
		
	}
	
	/*
	|--------------------------------------------------------------------------
	| Step 1: Preview - View
	|--------------------------------------------------------------------------
	*/
	public function get_index()
	{
		return Redirect::to('contribute/init');
	}
	
	/*
	|--------------------------------------------------------------------------
	| Step 1: Preview - View
	|--------------------------------------------------------------------------
	*/
	public function get_init($remove = null)
	{
		
		$data['title'] = 'Contribution Wizard - Step 1: Preview - Gaian.me';
		$data['user'] = $this->user;
		$data['draft'] = $this->draft;
		
		return View::make('conwizard.init', $data);
	}
	
	public function get_rempreview()
	{
		$path = Config::get('path.media.path').$this->draft->id;
		
		if(file_exists($path))
		{
			unlink($path.'/original.jpg');
			unlink($path.'/thumb.jpg');
			unlink($path.'/wide.jpg');
			unlink($path.'/large.jpg');
		}
		
		DB::table('draft_contributions')->where('id', '=', $this->draft->id)->update(array('preview' => null));
		
		return Redirect::to('contribute/init');
	}
	
	/*
	|--------------------------------------------------------------------------
	| Step 1: Preview - Engine
	|--------------------------------------------------------------------------
	*/
	public function post_init()
	{
		Bundle::start('resizer');
		
		$file = Input::file('file');
		
		$extension = strtolower(File::extension($file['name']));
		
		if($extension == 'jpeg' || $extension == 'jpg')
		{
			$path = Config::get('path.media.path').$this->draft->id;
			$filename = 'original.jpg';
			
			if(!file_exists($path)) mkdir($path, 0777);
		
			Input::upload('file', $path, $filename);
			
			$path_to_file = $path.'/'.$filename;
			
			Resizer::open($path_to_file)->resize(100, 100, 'crop')->save($path.'/thumb.jpg');
			Resizer::open($path_to_file)->resize(336, 130, 'crop')->save($path.'/wide.jpg');
			Resizer::open($path_to_file)->resize(840, 520, 'crop')->save($path.'/large.jpg');
			
			DB::table('draft_contributions')->where('id', '=', $this->draft->id)->update(array('preview' => 'set'));
			
		} else {
			return Redirect::to('contribute/init')->with('error', 'Only JPEG images are allowed as a preview.');
		}
		
		
		return Redirect::to('contribute/init');
	}
	
	/*
	|--------------------------------------------------------------------------
	| Step 2: Describe - View
	|--------------------------------------------------------------------------
	*/
	public function get_describe()
	{
		
		$data['title'] = 'Contribution Wizard - Step 2: Describe - Gaian.me';
		$data['user'] = $this->user;
		$data['draft'] = $this->draft;
		
		
		if($this->draft->preview == 'set')
		{
			return View::make('conwizard.describe', $data, $pro);
		} else {
			return Redirect::to('contribute/init');
		}
	}
	
	/*
	|--------------------------------------------------------------------------
	| Step 2: Describe - Engine
	|--------------------------------------------------------------------------
	*/
	public function post_describe()
	{
		$validation = Validator::make(Input::all(), array(
			'title' => 'required|max:80',
		));
		
		if ($validation->fails())
		{
		  return Redirect::to('contribute/describe')->with_errors($validation);
		} else {
			$data = Input::all();

			if (isset($data['download'])) {
			    $data['download'] = 0;
			} else {
				$data['download'] = 1;
			}

			DB::table('draft_contributions')->where('id', '=', $this->draft->id)->update($data);
			return Redirect::to('contribute/describe');
		}
		
	}
	
	/*
	|--------------------------------------------------------------------------
	| Step 3: Compose - View
	|--------------------------------------------------------------------------
	*/
	public function get_compose()
	{
		$data['title'] = 'Contribution Wizard - Step 3: Compose - Gaian.me';
		$data['user'] = $this->user;
		$data['draft'] = $this->draft;
		$data['file'] = DB::table('contribution_files')->where('handler', '=', $this->draft->id)->order_by('timestamp', 'desc')->first();
		
		if($this->draft->preview == 'set')
		{
			if($this->draft->title != '')
			{
				return View::make('conwizard.compose', $data);
			} else {
				return Redirect::to('contribute/describe');
			}
		} else {
			return Redirect::to('contribute/init');
		}
	}
	
	/*
	|--------------------------------------------------------------------------
	| Step 3: Compose - Engine
	|--------------------------------------------------------------------------
	*/
	public function post_compose()
	{
		$file = Input::file('file');
		
		$extension = strtolower(File::extension($file['name']));
		$path = Config::get('path.media.path').$this->draft->id;
		
		$filename = Str::slug($this->draft->title, '_').'.'.$extension;
		
		$path_to_file = $path.'/'.$filename;
		
		$data = array(
			'handler'=>$this->draft->id,
			'filename'=>$filename,
			'timestamp'=>time()
		);
		
		if($extension == 'jpg' || $extension == 'jpeg' || $extension == 'png')
		{
			Input::upload('file', $path, $filename);
			
			$data['type'] = 'image';
			
			DB::table('contribution_files')->insert($data);
		}
		elseif($extension == 'mp3')
		{
			Input::upload('file', $path, $filename);
			
			$data['type'] = 'music';
			
			DB::table('contribution_files')->insert($data);
		}
		elseif($extension == 'zip')
		{
			Input::upload('file', $path, $filename);
			
			$data['type'] = 'archive';
			
			DB::table('contribution_files')->insert($data);
		}
		else
		{
			return Redirect::to('contribute/compose')->with('error', 'JPEG, PNG, MP3 and ZIP files only.');
		}
		
		return Redirect::to('contribute/compose');
		
	}
	
	public function get_remfile()
	{
		$path = Config::get('path.media.path').$this->draft->id.'/';
		
		$file = DB::table('contribution_files')->where('handler', '=', $this->draft->id)->order_by('timestamp', 'desc')->first();
		
		if($file->filename != '')
		{
			if(file_exists($path.$file->filename))
			{
				unlink($path.$file->filename);
			}
			
			DB::table('contribution_files')->delete($file->id);
		}
		
		return Redirect::to('contribute/compose');
	}
	
	
	/*
	|--------------------------------------------------------------------------
	| Step 4: Final - View
	|--------------------------------------------------------------------------
	*/
	public function get_final()
	{
		$data['title'] = 'Contribution Wizard - Step 4: Review - Gaian.me';
		$data['user'] = $this->user;
		$data['draft'] = $this->draft;
		$data['file'] = DB::table('contribution_files')->where('handler', '=', $this->draft->id)->order_by('timestamp', 'desc')->first();
		
		if($this->draft->preview == 'set')
		{
			if($this->draft->title != '')
			{
				if($data['file']->filename != '')
				{
					return View::make('conwizard.final', $data);
				} else {
					return Redirect::to('contribute/compose');
				}
			} else {
				return Redirect::to('contribute/describe');
			}
		} else {
			return Redirect::to('contribute/init');
		}
	}
	
	/*
	|--------------------------------------------------------------------------
	| Final: Submit - View
	|--------------------------------------------------------------------------
	*/
	public function get_submit()
	{
		$draft = $this->draft;
		$file = DB::table('contribution_files')->where('handler', '=', $draft->id)->order_by('timestamp', 'desc')->first();
		
		//REMOVE DRAFT
		DB::table('draft_contributions')->delete($draft->id);
		
		//INSERT DRAFT TO CONTRIBUTIONS
		$data = array(
			'id'=>$draft->id,
			'status'=>1,
			'author'=>$draft->author,
			'title'=>$draft->title,
			'description'=>$draft->description,
			'type'=>$file->type,
			'tags'=>$draft->tags,
			'category'=>$draft->category,
			'timestamp'=>time(),
			'date'=>date('Y-m-d'),
			'preview'=>$draft->preview,
			'featured'=>0,
			'views'=>0,
			'licensed'=>$draft->licensed,
			'download'=>$draft->download
		);
		DB::table('contributions')->insert($data);
		
		//REDIRECT TO CONTRIBUTION
		return Redirect::to('discover/'.$draft->category.'/'.$draft->id);
	}
	
		
	
}