@include('layout.header')

<section id="profile" class="settings">
  <div class="container">

    <div class="content">

      <div class="row-fluid">

        @include('settings.ahead')

        <div class="span9 pull-right">

          {{ Form::open(null, 'POST', array('class' => 'form-horizontal')) }}

          @include('settings.notifications')
          			
          @if(Session::get('bad'))
          <div class="alert alert-error">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Oh snap!</strong> {{ Session::get('bad') }}
          </div>
          @endif
			
          @if(Session::get('good'))
          <div class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Well done!</strong> {{ Session::get('good') }}
          </div>
          @endif
			
          <fieldset>
            <div class="control-group">
              <label class="control-label" for="input01">Current password</label>
            
              <div class="controls">
                <input type="password" class="input-large" name="current_password" value="">
              </div>
            </div>
              
            <div class="control-group">
              <label class="control-label" for="input02">New password</label>
            
              <div class="controls">
                <input type="password" class="input-large" name="password" value="">
              </div>
            </div>
            
            <div class="control-group">
              <label class="control-label" for="input03">Repeat new password</label>
            
              <div class="controls">
                <input type="password" class="input-large" name="password_confirmation" value="">
              </div>
            </div>
          </fieldset>
			
          <div class="form-actions">
            <button class="btn">Save changes</button>
          </div>

          {{ Form::close() }}

        </div> <!-- .span9.pull-right -->

      </div> <!-- .row-fluid -->

		</div>

  </div>
</section>

@include('layout.footer')