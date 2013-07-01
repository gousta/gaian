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
              <label class="control-label" for="input01">My Country</label>
            
              <div class="controls">
                <input type="text" class="input-large" name="country" value="{{ $user->country }}">
              </div>
            </div>
            
            <div class="control-group">
              <label class="control-label" for="input02">My City</label>
            
              <div class="controls">
                <input type="text" class="input-large" name="city" value="{{ $user->city }}">
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