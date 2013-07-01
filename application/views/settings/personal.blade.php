@include('layout.header')

<section id="profile" class="settings">
  <div class="container">

    <div class="content">

      <div class="row-fluid">

        @include('settings.ahead')

        <div class="span9 pull-right">

          {{ Form::open(null, 'POST', array('class' => 'form-horizontal')) }}

          @include('settings.notifications')

          <fieldset>
            <div class="control-group">
              <label class="control-label" for="input01">My first name</label>
            
              <div class="controls">
                <input type="text" class="input-xlarge" name="first_name" value="{{ $user->first_name }}">
              </div>
            </div>
            
            <div class="control-group">
              <label class="control-label" for="input02">My last name</label>
            
              <div class="controls">
                <input type="text" class="input-xlarge" name="last_name" value="{{ $user->last_name }}">
              </div>
            </div>
            
            <div class="control-group">
              <label class="control-label" for="input03">My Social bio</label>
            
              <div class="controls">
                <input type="text" class="input-xxlarge" name="social_status" value="{{ $user->social_status }}" placeholder="eg. Gaian addict">
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