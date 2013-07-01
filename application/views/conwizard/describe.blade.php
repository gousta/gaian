@include('layout.header')


<section id="contribution">
	<div class="container">

		<div class="content">
			
			
			<div class="progress progress-warning pull-right" style="width: 200px;margin-top: 10px;">
				<div class="bar" style="width: 50%; background:#333"></div>
			</div>
			
			<h1>Describe your awesome contribution</h1><hr/><br/>
			
			<a href="{{ URL::base() }}/contribute/init" class="btn btn-large btn-inverse pull-left" style="font-size:20px"><i class="icon-chevron-left"></i></a>
			
			@if($draft->title != '' && $draft->preview == 'set')
			<a href="{{ URL::base() }}/contribute/compose" class="btn btn-large btn-inverse pull-right" style="font-size:20px"><i class="icon-chevron-right"></i></a>
			@endif
			
			{{ Form::open(null, 'POST', array('class' => 'form-horizontal')) }}
			
			<div class="row-fluid">
				
				<div style="width: 840px;margin: 0px auto;">
						
				@if ($errors->all())
				<div class="alert alert-error">
					 <button type="button" class="close" data-dismiss="alert">&times;</button>
					 <strong>Oh snap!</strong>
					 <ul>
					 @foreach ($errors->all() as $error)
					 	<li>{{ $error }}</li>
					 @endforeach
					 </ul>
				 </div>
				 @endif
					
					<fieldset>
						<div class="control-group">
							<label class="control-label" for="input01">Title</label>
							
							<div class="controls">
								<input type="text" class="input-xxlarge" name="title" value="{{ $draft->title }}">
								<p class="help-block"><strong>Note:</strong> A title needs to be set to continue.</p>
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="input04">Category</label>
							
							<div class="controls">
								<select class="input-xxlarge" name="category">
									<option value="wallpaper" {{ ($draft->category == 'wallpaper') ? 'selected="selected"':'' }}>Wallpaper</option>
									<option value="theme" {{ ($draft->category == 'theme') ? 'selected="selected"':'' }}>Theme</option>
									<option value="tools" {{ ($draft->category == 'tools') ? 'selected="selected"':'' }}>Tool</option>
									<option value="music" {{ ($draft->category == 'music') ? 'selected="selected"':'' }}>Music</option>
									<option value="icons" {{ ($draft->category == 'icons') ? 'selected="selected"':'' }}>Icons</option>
									
								</select>
								<p class="help-block"><strong>Note:</strong> A Category needs to be set to continue.</p>
							</div>
						</div>

						<div class="control-group">
							<label class="control-label" for="input02">Tags</label>
							
							<div class="controls">
								<input type="text" class="input-xxlarge" name="tags" value="{{ $draft->tags }}">
								<p class="help-block"><strong>Note:</strong> Comma delimited</p>
							</div>
						</div>

						<div class="control-group">
							<label class="control-label" for="input03">Description</label>
							
							<div class="controls">
								<textarea name="description" class="input-xxlarge" rows="5" style="resize: none">{{ $draft->description }}</textarea>
							</div>
						</div>
						
						@if(Auth::user()->pro == '1')
						<div class="control-group">
							<label class="control-label" for="input05">Available for Dowload</label>
							
							<div class="controls">
								{{ Form::checkbox('download', 'yes', false, array('id' => 'input05')) }}
							</div>
						</div>
						@endif
						<!--
						<div class="control-group">
							<label class="control-label" for="input04">&nbsp;</label>
							
							
							<div class="controls">
								<label class="checkbox">
									<input type="checkbox" name="licensed" value="1" {{ $draft->licensed ? 'checked':'' }} id="input04">
									
									My contribution is licensed under the Creative Commons license
								</label>
								
							</div>
						</div>
						-->
						
						
						
					</fieldset>
					
					<div class="form-actions">
						<button class="btn btn-warning">Save changes</button>
					</div>
					
				</div>
				
			</div>
				
			{{ Form::close() }}



		</div>

	</div>
</section>




@include('layout.footer')