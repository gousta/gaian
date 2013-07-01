@include('layout.header')


<section id="join-page">
  <div class="container">
  
    <div class="content">

      <div class="row-fluid">

        <div class="span6">
          <h3 class="join-with">Use your facebook account to join us</h3>

          <a class="btn btn-facebook btn-large" href="{{ URL::base() }}/connect/facebook"><i class="icon-facebook-sign"></i> Sign up with Facebook</a>

          <p class="join-info">
            Welcome to Gaian.me! This is your personal gaian passport,<br/>
            making you a gaian to join a world wide community<br/>
            of {{ $gaians }} gaians celebrating the beauty of nature everyday!
          </p>
        </div>

        <div class="span6">

          <h3 class="join-with">Use registration form <small>or <a href="{{ URL::base() }}/sign-in">sign in</a></small></h3>

          @include('settings.notifications')

          {{ Form::open(null, 'POST') }}

          <div class="row-fluid">
            <div class="span6">
              <div class="control-group">
                <div class="controls">
                  <input type="text" placeholder="Username" id="input01" name="username">
                </div>
              </div>
              
              <div class="control-group">
                <div class="controls">
                  <input type="text" placeholder="Email Address" id="input02" name="email">
                </div>
              </div>
              
              <div class="control-group">            
                <div class="controls">
                  <input type="password" placeholder="Password" id="input03" name="password">
                </div>
              </div>
              
              <div class="control-group">            
                <div class="controls">
                  <input type="password" placeholder="Confirm Password" id="input04" name="password_confirmation">
                </div>
              </div>
              
              {{ recaptcha_get_html(Config::get('recaptcha.publickey')) }}

            </div>


            <div class="span6">
              <div class="control-group">
                <div class="controls">
                  <input type="text" placeholder="First Name" id="input01" name="first_name">
                </div>
              </div>
              
              <div class="control-group">
                <div class="controls">
                  <input type="text" placeholder="Last Name" id="input01" name="last_name">
                </div>
              </div>
            
              <div class="control-group">
                <div class="controls">
                  <p>With my gaian passport I agree to celebrate<br/> nature and our planet everyday.</p>
                  <button type="submit" class="btn pull-right">Sign up</button>
                </div>
              </div>
            </div>

          </div>

          {{ Form::close() }}

        </div>

      </div> <!-- .row -->

    </div>

  </div>
</section>

@include('layout.footer')