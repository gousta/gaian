@include('layout.header')

<section id="forum">
	<div class="container">
		
		<div class="content">
			
			<h2>Edit: {{ $topic->name }}</h2><hr/>
			
			{{ Form::open(null, 'POST', array('class' => 'form-horizontal')) }}
			
				<fieldset>
				
					@if ($errors->all())
					<div class="alert alert-error">
		        <button type="button" class="close" data-dismiss="alert">×</button>
		        <strong>Oh snap!</strong>
		        <ul>
		        @foreach ($errors->all() as $error)
				    	<li>{{ $error }}</li>
				    @endforeach
		        </ul>
		      </div>
		      @endif
			    
			    <div class="control-group">
			      <label class="control-label" for="input01">Topic</label>
			      <div class="controls">
			        <input type="text" style="width:700px" id="input01" name="topic" value="{{ $topic->name }}">
			      </div>
			    </div>
			    
			    <div class="control-group">
			      <label class="control-label" for="input01">Content</label>
			      <div class="controls">
			        <textarea id="textarea" rows="8" style="width:700px" name="content">{{ $topic->post }}</textarea>
			      </div>
			    </div>
			    
			    <div class="form-actions">
            <button type="submit" class="btn btn-warning">Save changes</button>
            <a class="btn" href="{{ URL::base() }}/forum/{{ $forum }}/{{ $topic->slug }}">Cancel</a>
          </div>
          
			  </fieldset>
			
			
			{{ Form::close() }}
			
			<hr/>
			
			
		</div>
		
	</div>
</section>

@include('layout.footer')