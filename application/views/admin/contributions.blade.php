@include('admin.layout.header')

<div class="container">

	<ul class="breadcrumb">
		<li><a href="/admin">Admin</a> <span class="divider">/</span></li>
		<li class="active">Contributions</li>
	</ul>
	
	<ul class="thumbnails">
		@foreach($contributions->results as $contribution)
	    <li class="span4">
	      <div class="thumbnail" style="height: 100px">
	        <img src="{{ Config::get('path.media.url') }}{{ $contribution->id }}/thumb.jpg" alt="" class="pull-left">
	        <div class="caption" style="margin-left: 100px;position:relative;height: 81px;">
	          <p style="font-weight:bold;font-size: 16px;">{{ $contribution->title }}</p>
	          <p>
		          <div class="btn-group pull-right" style="position:absolute; right: 0; bottom: 0;">
		          	@if($contribution->featured == 1)
									<a href="/admin/contributions/unfeature/{{ $contribution->id }}" class="btn"><i class="icon-star"></i></a>
								@else
									<a href="/admin/contributions/feature/{{ $contribution->id }}" class="btn"><i class="icon-star-empty"></i></a>
								@endif
								
								<a href="/admin/contributions/edit/{{ $contribution->id }}" class="btn"><i class="icon-pencil"></i></a>
							</div>
	          </p>
	        </div>
	      </div>
	    </li>
		@endforeach
	</ul>
	
	
	{{ $contributions->links() }}

</div>

@include('admin.layout.footer')