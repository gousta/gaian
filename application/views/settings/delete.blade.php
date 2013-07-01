@include('layout.header')

<section id="profile" class="settings">
  <div class="container">

    <div class="content">

      <div class="row-fluid">

        @include('settings.ahead')

        <div class="span9 pull-right">

          {{ Form::open(null, 'POST', array('class' => 'form-horizontal')) }}

          @if(Session::get('bad'))
          <div class="alert alert-error">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            {{ Session::get('bad') }}
          </div>
          @endif

          <fieldset>
            <div class="control-group">
              <label class="control-label" for="input01"><strong>Note</strong></label>
              
              <div class="controls">
                <p>If you choose to delete your Gaian.me Account, your <strong>account data, contributions, draft contributions,<br/>celebrations, comments, engagements, notifications, forum topics, topic posts and swarms</strong> will all be deleted.</p>
                
                <div class="alert">
                <strong>We cannot restore your account data after this process.</strong>
                </div>
                
                <p>To delete your account, please enter your current password in the Password field underneath and click on the button below:</p>
              </div>
            </div>

            <div class="control-group">
              <label class="control-label" for="input01">Password</label>
            
              <div class="controls">
                <input type="password" class="input-large" name="password" value="">
              </div>
            </div>
          </fieldset>
			
          <div class="form-actions">
            <button class="btn btn-danger" data-loading-text="Loading...">Delete my account</button>
          </div>

          {{ Form::close() }}

        </div> <!-- .span9.pull-right -->

      </div> <!-- .row-fluid -->

		</div>

  </div>
</section>

@include('layout.footer')