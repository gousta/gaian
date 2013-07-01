@include('layout.header')


<section id="contribution">
	<div class="container">

		<div class="content">
			
			
      <div class="progress pull-right" style="width: 200px;margin-top: 10px;">
      	<div class="bar" style="width: 25%; background:#333"></div>
      </div>
      
			<h1>It's great you contribute to Gaia!</h1><hr/><br/>
			
			@if(Session::has('error'))
				<div class="alert alert-block">
					<button type="button" class="close" data-dismiss="alert">&times;</button>
					<h4 class="alert-heading">Warning!</h4>
					<p>{{ Session::get('error') }}</p>
				</div>
			@endif
			
			@if($draft->preview == 'set')
			<a href="{{ URL::base() }}/contribute/describe" class="btn btn-large btn-inverse pull-right" style="font-size:20px"><i class="icon-chevron-right"></i></a>
			@endif
			
			{{ Form::open_for_files(null, 'POST', array('class' => 'form-horizontal', 'id' => 'upload_form')) }}
			
			<div class="row-fluid">
				<div class="art-info" style="width: 840px;margin: 0px auto;">
					<figure style="box-shadow: 0px 0px 15px rgba(50, 50, 50, 0.5);border:none;width: 840px;height: 520px;background:#fff;text-align: center;position:relative;">
							
							@if($draft->preview == 'set')
								<img src="{{ Config::get('path.media.url') }}{{ $draft->id }}/large.jpg?{{ rand(0, 9999).Str::random(12) }}" />
								<a class="btn btn-danger" style="position:absolute; top: 20px; right: 20px;" href="{{ URL::base() }}/contribute/rempreview">remove</a>
							@else
								<div style="padding-top: 225px" id="input">
									
									<span class="btn btn-large" style="position:relative;padding: 12px 40px;cursor: pointer;">Add preview image
										
										<input id="file" name="file" type="file" style="top: 0; left: 0;cursor: pointer;filter: alpha(opacity=0);margin: 0;opacity: 0;padding: 0;position: absolute;z-index: 1;height: 41px;">
										
									</span>
									<p style="padding-top: 20px;color:#999">(The preview might be resized to fit the frame size)</p>
									
								</div>
								
								<div style="padding-top: 240px;display:none" id="loading">
									<img src="/assets/img/loader.small.gif">
								</div>
							@endif
					
					</figure>
				</div>
			</div>
			
			{{ Form::close() }}


			
			</p>
		</div>

	</div>
</section>




@include('layout.footer')