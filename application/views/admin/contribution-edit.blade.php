@include('admin.layout.header')

<div class="container">

	<ul class="breadcrumb">
		<li><a href="/admin">Admin</a> <span class="divider">/</span></li>
		<li><a href="/admin/contributions">Contributions</a> <span class="divider">/</span></li>
		<li class="active">{{ $contribution->title }}</li>
	</ul>

	{{ Form::open(null, 'POST', array('class'=>'form-horizontal')) }}
		
		<a href="/discover/{{ $contribution->id }}" target="_blank"><i class="icon-external-link"></i> View contribution on a new tab</a>
		<hr/>
		
		@include('admin.layout.notifications')
		
		<div class="control-group">
	    <label class="control-label" for="title">Title</label>
	    <div class="controls">
	      <input type="text" id="title" name="title" placeholder="Title" value="{{ $contribution->title }}" class="input-xxlarge">
	    </div>
	  </div>
	  
		<div class="control-group">
	    <label class="control-label" for="tags">Tags</label>
	    <div class="controls">
	      <input type="text" id="tags" name="tags" placeholder="tags" value="{{ $contribution->tags }}" class="input-xxlarge">
	    </div>
	  </div>
	  
		<div class="control-group">
	    <label class="control-label" for="description">Description</label>
	    <div class="controls">
	      <textarea id="description" name="description" placeholder="description" class="input-xxlarge" rows="7">{{ $contribution->description }}</textarea>
	    </div>
	  </div>
	  
	  <div class="form-actions">
			<button type="submit" class="btn btn-inverse">Save changes</button>
			<a href="/admin/contributions" class="btn">Cancel</a>
		</div>
		
	{{ Form::close() }}

</div>

@include('admin.layout.footer')