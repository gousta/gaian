@include('layout.header')

<section id="contribution">
	<div class="container">

		<div class="content">
		
			<h1>Edit: {{ $item->title }}</h1><hr/><br/>

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
								<input type="text" class="input-xxlarge" name="title" value="{{ $item->title }}">
								<p class="help-block"><strong>Note:</strong> A title needs to be set.</p>
							</div>
						</div>

						<div class="control-group">
							<label class="control-label" for="input02">Tags</label>
							
							<div class="controls">
								<input type="text" class="input-xxlarge" name="tags" value="{{ $item->tags }}">
								<p class="help-block"><strong>Note:</strong> Comma delimited</p>
							</div>
						</div>

						<div class="control-group">
							<label class="control-label" for="input03">Description</label>
							
							<div class="controls">
								<textarea name="description" class="input-xxlarge" rows="5" style="resize: none">{{ $item->description }}</textarea>
							</div>
						</div>
						
						<hr/>
						
						<div class="control-group">
							<label class="control-label" for="input03">&nbsp;</label>
							
							<div class="controls">
								<p><strong>Note:</strong> We currently don't support editing the preview or the contribution file.</p>
							</div>
						</div>
						
					</fieldset>
					
					<div class="form-actions">
						<button class="btn btn-warning">Save changes</button>
						<a href="{{ URL::base() }}/discover/{{ $item->category }}/{{ $item->id }}" class="btn">Cancel</a>
					</div>
					
				</div>
				
			</div>
				
			{{ Form::close() }}
			
		</div>

	</div>
</section>

@include('layout.footer')