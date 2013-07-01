@include('layout.header')

<section id="profile" class="settings">
  <div class="container">

    <div class="content">

      <div class="row-fluid">

        @include('settings.ahead')

        <div class="span9 pull-right">
	        
	        @if($fb->id)
	        	<p>Connected facebook account:</p>
	        
	        	<table class="table table-bordered">
	        		<tbody>
	        			<td style="vertical-align:middle;width: 50px"><img src="http://graph.facebook.com/{{ $user->fbid }}/picture" style="border-radius: 3px"></td>
	        			<td style="vertical-align:middle;padding-left: 10px;">
	        					<div style="font-size: 18px">{{ $fb->name }}</div>
	        					<a href="http://www.facebook.com/{{ $fb->username ? $fb->username:$fb->id }}" style="font-size: 12px;">www.facebook.com/{{ $fb->username ? $fb->username:$fb->id }}</span>
	        			</td>
	        		</tbody>
	        	</table>
	        @else
          <p>Connect your facebook account and take advantage of the Quick Login features. To do so, click on the button below:</p>
          
          
          <a class="btn btn-facebook btn-large" href="{{ URL::base() }}/connect/facebook"><i class="icon-facebook-sign"></i> Connect my Gaian Passport with Facebook</a>
	        
	        @endif

        </div> <!-- .span9.pull-right -->

      </div> <!-- .row-fluid -->

		</div>

  </div>
</section>

@include('layout.footer')