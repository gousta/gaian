@include('admin.layout.header')

<div class="container">

	<ul class="breadcrumb">
		<li><a href="/admin">Admin</a> <span class="divider">/</span></li>
		<li><a href="/admin/passports">Passports</a> <span class="divider">/</span></li>
		<li class="active">{{ $user->username }}</li>
	</ul>

	{{ Form::open(null, 'POST', array('class'=>'form-horizontal')) }}
		
		@include('admin.layout.notifications')
		
		<?php $fields = array(
			array('fbid','Facebook ID', $user->fbid),
			array('email','Email', $user->email),
			array('first_name','First Name', $user->first_name),
			array('last_name','Last Name', $user->last_name),
			array('website_display','Website', $user->website_display),
			array('website_url','Website url', $user->website_url),
			array('country','Country', $user->country),
			array('city','City', $user->city),
			array('role','Role', $user->role),
			array('points','Points', $user->points),
		); ?>
		
		@foreach($fields as $field)
		<div class="control-group">
	    <label class="control-label" for="{{ $field[0] }}">{{ $field[1] }}</label>
	    <div class="controls">
	      <input type="text" id="{{ $field[0] }}" name="{{ $field[0] }}" placeholder="{{ $field[1] }}" value="{{ $field[2] }}" class="input-xxlarge">
	    </div>
	  </div>
		@endforeach
	  
	  <div class="form-actions">
			<button type="submit" class="btn btn-inverse">Save changes</button>
			<a href="/admin/passports" class="btn">Cancel</a>
		</div>
		
	{{ Form::close() }}

</div>

@include('admin.layout.footer')