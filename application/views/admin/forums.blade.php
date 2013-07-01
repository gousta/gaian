@include('admin.layout.header')

<div class="container">

	<ul class="breadcrumb">
		<li><a href="/admin">Admin</a> <span class="divider">/</span></li>
		@if($_category)
			<li><a href="/admin/forums">Forums</a> <span class="divider">/</span></li>
		@else
			<li class="active">Forums</li>
		@endif
		
		@if($_category && !$_forum)
			<li class="active">{{ $c_category->name }}</li>
		@endif
		@if($_category && $_forum)
			<li><a href="/admin/forums/show/{{ $_category }}">{{ $c_category->name }}</a> <span class="divider">/</span></li>
		@endif
		
		@if($_forum)
			<li class="active">{{ $c_forum->name }}</li>
		@endif
	</ul>
	
	<p>Pick a category, a forum or topic.</p>
	
	<div class="row">
	
		<div class="span4">
			<h3>Categories</h3>
			
			<table class="table table-striped">
				<tbody>
					@foreach($forumcats as $forumcat)
						<tr>
							<td style="vertical-align:middle">{{ $forumcat->name }}</td>
							<td width="50">
								<div class="btn-group">
									<a href="/admin/forums/edit/{{ $forumcat->forum_cat_id }}" class="btn btn-small"><i class="icon-pencil"></i></a>
									<a href="/admin/forums/show/{{ $forumcat->forum_cat_id }}" class="btn btn-small {{ ($forumcat->forum_cat_id == $_category) ? 'btn-primary':'' }}"><i class="icon-chevron-right"></i></a>
								</div>
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
		
		<div class="span4">
			<h3>Forums</h3>
			
			{{ Form::open(null, 'POST', array('class'=>'form-inline')) }}
				
				<div class="input-append">
					<input class="span3" name="forum_name" type="text">
					<button class="btn" type="submit"><i class="icon-plus"></i></button>
				</div>
				
			{{ Form::close() }}
			
			@if(count($forums) > 0)
				<table class="table table-striped">
					<tbody>
						@foreach($forums as $forum)
							<tr>
								<td style="vertical-align:middle">{{ $forum->name }}</td>
								<td width="50">
									<div class="btn-group">
										<a href="/admin/forums/edit/{{ $_category }}/{{ $forum->forum_id }}" class="btn btn-small"><i class="icon-pencil"></i></a>
										<a href="/admin/forums/show/{{ $_category }}/{{ $forum->forum_id }}" class="btn btn-small {{ ($forum->forum_id == $_forum) ? 'btn-primary':'' }}"><i class="icon-chevron-right"></i></a>
									</div>
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			@else
				<p>No forums.</p>
			@endif
		</div>
		
		<div class="span4">
			<h3>Topics</h3>
		
			@if(count($topics) > 0)
				<table class="table table-striped">
					<tbody>
						@foreach($topics as $topic)
							<tr>
								<td style="vertical-align:middle">{{ $topic->name }}</td>
								<td width="30"><a href="/admin/forums/edit/{{ $_category }}/{{ $_forum }}/{{ $topic->topic_id }}" class="btn btn-small"><i class="icon-pencil"></i></a></td>
							</tr>
						@endforeach
					</tbody>
				</table>
			@else
				<p>No topics.</p>
			@endif
		</div>
		
	</div>

</div>

@include('admin.layout.footer')