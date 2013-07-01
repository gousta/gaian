@include('layout.header')

<a href="{{ URL::base() }}" class="login-logo">gaian.me</a>

<section id="login-page">
  <div class="container">

    <div class="content span6">

      <div class="row-fluid">

      <div class="span6 login-with">
        <h3 class="login-banner">Use your facebook<br/> account to sign in:</h3>
        
        <a class="btn btn-facebook btn-large" href="{{ URL::base() }}/connect/facebook" data-width="200"><i class="icon-facebook-sign"></i> Sign in with Facebook</a>
      </div>

      <div class="line"></div>

      <div class="span6">
        <h3 class="login-banner">Sign in <small>or <a href="{{ URL::base() }}/join">sign up</a></small></h3>

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
  
          <label class="checkbox pull-left">
            <input type="checkbox" name="remember" checked="checked"> Remember me
          </label>
          
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

      <hr/>
      <h6 class="pull-center">join us, celebrate, comment, and show some love.</h6>

    </div>
    
  </div>
</section>

<div class="login-foot">
  <ul>
    <li><a href="{{ URL::base() }}/discover">Discover</a></li>
    <li><a href="{{ URL::base() }}/join">Get involved</a></li>
    <li><a href="{{ URL::base() }}/forum">Forum</a></li>
  </ul>
</div>

@include('layout.footer')