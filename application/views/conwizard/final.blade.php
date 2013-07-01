@include('layout.header')

<section id="contribution">
	<div class="container">

		<div class="content">
			
			<h1>Review your contribution &amp; submit!</h1><hr/><br/>
			
			<div class="row-fluid">

				<div class="art-info span9">
					<figure>
						<img src="{{ Config::get('path.media.url') }}{{ $draft->id }}/large.jpg?{{ rand(0,999) }}" width="100%" />
					</figure>

					<div class="details">
						<div class="art-title">
							<img src="{{ Load::avatar() }}" class="pull-left rounded">
						
							<div class="pull-left">
								<h1>{{ $draft->title }}</h1>
								<a href="{{ URL::base() }}/user/{{ $user->username }}">by {{ $user->first_name }} {{ $user->last_name }}</a>
							</div>
						</div>
	
						<div class="description">
							{{ nl2br($draft->description) }}
						</div>
					</div>
				</div>
				
				
				<div class="art-actions span3">
				
					@if($draft->title != '' && $draft->preview == 'set' && $file)
						
						<h3 class="pull-right">Quick edit:</h3>
						<div class="btn-group pull-right">
		          <a href="{{ URL::base() }}/contribute/init" class="btn btn-inverse">Preview</a>
		          <a href="{{ URL::base() }}/contribute/describe" class="btn btn-inverse">Describe</a>
		          <a href="{{ URL::base() }}/contribute/compose" class="btn btn-inverse">Compose</a>
		      	  </hr></br>
		          

		        </div>
				
					
					@endif
				</div>

		</div>
		
		<a href="{{ URL::base() }}/contribute/submit" class="btn btn-large btn-warning pull-right">Submit to contributions</a>	
		<br/><br/><hr/>
		<p  style="font-size:16px;font-weight: bold" align="right">You must own the copyright or have the necessary rights for any content you upload.
			<a href="{{ URL::base() }}/copyright">Learn more</a> </p>
	</div>
</section>

@include('layout.footer')