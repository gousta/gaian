@include('layout.header')


<section id="contribution">
	<div class="container">

		<div class="content">
			
			
			<div class="progress progress-warning pull-right" style="width: 200px;margin-top: 10px;">
				<div class="bar" style="width: 75%; background:#333"></div>
			</div>
			
			<h1>Add your contribution file</h1><hr/><br/>
			
			
			<a href="{{ URL::base() }}/contribute/describe" class="btn btn-large btn-inverse pull-left" style="font-size:20px"><i class="icon-chevron-left"></i></a>
			
			@if($draft->title != '' && $draft->preview == 'set' && $file)
			<a href="{{ URL::base() }}/contribute/final" class="btn btn-large btn-inverse pull-right" style="font-size:20px"><i class="icon-chevron-right"></i></a>
			@endif
			
			
			
			<div class="row-fluid">
				<div style="width: 840px;margin: 0px auto;">
				
					@if(Session::has('error'))
						<div class="alert alert-block">
							<button type="button" class="close" data-dismiss="alert">&times;</button>
							<h4 class="alert-heading">Warning!</h4>
							<p>{{ Session::get('error') }}</p>
						</div>
					@endif
					
					@if($file)
					
					<table class="table table-striped table-bordered">
						<tbody>
							<tr>
								<td width="70">
									@if($file->type == 'image')
										<i class="icon-white icon-picture" style="font-size: 40px;padding-top: 4px;float: left;"></i>
									@endif
									@if($file->type == 'music')
										<i class="icon-white icon-headphones" style="font-size: 40px;padding-top: 4px;float: left;"></i>
									@endif
									@if($file->type == 'archive')
										<i class="icon-white icon-briefcase" style="font-size: 40px;padding-top: 4px;float: left;"></i>
									@endif
								</td>
								<td style="vertical-align:middle;border:none;" width="70"><span class="label" style="background-color: #444;font-weight:400;">{{ $file->type }}</span></td>
								<td style="vertical-align:middle;border:none;">
									<span class="label" style="background-color: transparent;color:#444;font-weight:400;text-shadow: none">
										{{ Utilities::bytes(filesize(Config::get('path.media.path').$draft->id.'/'.$file->filename), 0) }}
									</span>
								</td>
								
								<td width="10" style="vertical-align:middle;border:none;">
									<a href="{{ URL::base() }}/contribute/remfile" class="btn btn-danger">remove</a>
								</td>
							</tr>
						</tbody>
					</table>
					
					@else
					
						{{ Form::open_for_files(null, 'POST', array('class' => 'form-horizontal', 'id' => 'upload_form')) }}
					
						<div class="well">
						
							
							<h4>You may upload:</h4><hr/>
							<span class="btn btn-warning pull-right" style="position:relative;cursor: pointer;padding: 6px 20px;">Add file
								<input id="file" name="file" type="file" style="top: 0; left: 0;cursor: pointer;filter: alpha(opacity=0);margin: 0;opacity: 0;padding: 0;position: absolute;z-index: 1;height: 31px;width: 86px;">
							</span>
							
							<ul>
								<li>
									Image: commonly used for single wallpaper or photography.
									<ul><li>.jpeg (.jpg), .png</li></ul>
								</li>
								<li>
									Song: used for single music file submission.
									<ul><li>.mp3</li></ul>
								</li>
								<li>
									Archive: used for all categories that contain more than one file.
									<ul><li>.zip</li></ul>
								</li>
							</ul>
							
						</div>
							
							<div style="display:none;text-align:center;" id="loading">
								<img src="/assets/img/loader.small.gif">
							</div>
						
						{{ Form::close() }}
					
					@endif
					
					
					
					
					
						
				</div>
			</div>
			
			

		</div>

	</div>
</section>




@include('layout.footer')