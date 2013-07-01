@include('layout.header')

<a href="{{ URL::base() }}" class="login-logo">gaian.me</a>

<section id="login-page">
  <div class="container">

    <div class="content span4">

      <div class="row-fluid">

      <div class="span12">
        <h3 class="login-banner">One last step before your account is created</h3>

        {{ Form::open(null, 'POST') }}

          <div class="control-group">
            <div class="controls">
              <input type="text" placeholder="Email" id="input01" name="email">
            </div>
          </div>
        
          <div class="control-group">           
            <div class="controls">
              <input type="password" placeholder="Password" id="input01" name="password">
            </div>
          </div>
          
          <button type="submit" class="btn btn-warning pull-right">Sign in</button>

        {{ Form::close() }}
	
	      @if(isset($error))
	        <div class="alert alert-error">
	          <a class="close" data-dismiss="alert" href="#"><i class="icon-remove"></i></a>
	          <strong>Oh snap!</strong> {{ $error }}
	        </div>
	      @endif

      </div>

      </div>

    </div>
    
  </div>
</section>

@include('layout.footer')