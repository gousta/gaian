@include('layout.header')
<section id="discover">
    <div class="container">

    	@if(count($contributions) > 0)

			
    		
			<div id="artworks-wall" class="row">
				<div class="thumbnails">

					@foreach ($contributions as $item)

						<div class="span4 artwork">
							<a class="thumbnail" href="{{ URL::base() }}/discover/{{ $item->category   }}/{{ $item->id }}">
								<img src="{{ Config::get('path.media.url') }}{{ $item->id }}/wide.jpg" alt="{{ $item->title }}" />
							</a>

							<div class="description">
								<div class="row-fluid">
									<div class="span10">
										<span class="work-info">{{ $item->title }} <a href="{{ URL::base() }}/user/{{ $item->username }}">by {{ $item->first_name }} {{ $item->last_name }}</a></span>
									</div>

									<div class="span2">
										<!--<span class="likes-count">0 <i class="icon-eko-dark"></i></span>-->
									</div>
								</div>
							</div>
						</div>

					@endforeach

				</div>
			</div>

		@else

	    		<h3 class="join-with">
				Sorry, no results found
				</h3>

		@endif



	</div>
 </section>

  

@include('layout.footer')