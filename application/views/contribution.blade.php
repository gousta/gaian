@include('layout.header')

<section id="contribution">
	<div class="container">

		<div class="content">
		
			@if(Auth::check())
				@if(Auth::user()->id == $item->author)
					<div class="btn-group pull-right">
						<a href="{{ URL::current() }}/edit" class="btn btn-inverse"><i class="icon-edit"></i> Edit mode</a>
						<a href="{{ URL::current() }}/delete" class="btn btn-danger" onclick="return confirm('Are you sure?')"><i class="icon-trash"></i> Trash</a>
					</div>
				@endif
			@endif

			<div class="row-fluid">
				<ul class="breadcrumb span9">
					<li>
						<a href="{{ URL::base() }}/discover">Discover</a> <span class="divider">&rsaquo;</span>
					</li>
					<li>
						<a href="{{ URL::base() }}/discover/{{ $item->category }}">{{ ucfirst($item->category) }}</a> <span class="divider">&rsaquo;</span>
					</li>

					<li class="active">{{ $item->title }}</li>
				</ul>
					
				
				@if(isset($success))
					<div class="alert alert-success span9">
						<button type="button" class="close" data-dismiss="alert">×</button>
						<strong>Nice!</strong> {{ $success }}.
					</div>
				@endif
			</div>

			<div class="row-fluid">

				<div class="art-info span9">
					<figure>
						<img src="{{ Config::get('path.media.url') }}{{ $item->id }}/large.jpg" width="100%" />
					</figure>

					<div class="details">
						<div class="art-title">
							<img src="{{ Load::avatar($item->avatar, $item->uid) }}" class="pull-left rounded">
						
							<div class="pull-left">
								<h2>{{ $item->title }}</h2>
								<a href="{{ URL::base() }}/user/{{ $item->username }}">by {{ $item->first_name }} {{ $item->last_name }}</a>
							</div>
						</div>
	
						<div class="description">
							{{ Utilities::linkify(nl2br($item->description)) }}
						</div>
					</div>
				</div>

				<div class="art-actions span3">

					@if($item->download == '0')
								<a href="{{ URL::base() }}/discover/{{ $item->category }}/{{ $item->id }}/download" class="btn btn-large btn-warning"><i class="icon-download"></i> Download</a>
					@endif

					<div class="share">
						<h5>Share</h5>
						<hr/>
						<div class="fb-like" data-href="{{ URL::base() }}/discover/{{ $item->id }}" data-send="false" data-layout="button_count" data-show-faces="false" data-font="lucida grande"></div>
						<a href="https://twitter.com/share" class="twitter-share-button" data-lang="en" data-url="{{ URL::base() }}/discover/{{ $item->id }}">Tweet</a>
					</div>
					
					<div class="tags">
						<h5>Tags</h5>
						<hr/>
						@foreach($tags as $tag)
							@if($tag != '')
								<span class="label label-inverse">{{ $tag }}</span>
							@endif
						@endforeach
					</div>

					<div class="moreby">
						<h5>More from <a href="{{ URL::base() }}/user/{{ $item->username }}">{{ $item->first_name }}</a></h5>
						<hr/>
						
						<ul class="thumbnails">

							@foreach ($related as $relitem)
							
							<li class="span4">
								<a href="{{ URL::base() }}/discover/{{ $relitem->category }}/{{ $relitem->id }}" class="thumbnail" {{ ($relitem->id == $item->id) ? 'style="border-color:#09a8bd"':'' }}>
									<img src="{{ Config::get('path.media.url') }}{{ $relitem->id }}/thumb.jpg" />
								</a>
							</li>
							
							@endforeach
							
						</ul>
					</div>
				</div>

			</div>

			<hr/>
			
			@include('layout.comment:block')

		</div>

	</div>
</section>

@include('layout.footer')