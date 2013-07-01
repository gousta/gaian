@include('layout.header')

<section id="forum">
  <div class="container">

    <div class="content">

      <h3>Add a new topic</h3>

      <hr/>

      @include('settings.notifications')

      <div class="row">

        <div class="span9 offset1">
          {{ Form::open(null, 'POST', array('class' => 'form')) }}
    
          <div class="control-group">
            <div class="controls">
              <input type="text" id="input01" name="topic" placeholder="Topic title" class="span9">
            </div>
          </div>
          
          <div class="control-group">
            <div class="controls">
              <textarea id="textarea" rows="8" name="content" placeholder="Content" class="span9"></textarea>
            </div>
          </div>
    
          <div class="form-actions">
            <button type="submit" class="btn btn-warning">Post topic</button>
            <a class="btn" href="{{ URL::base() }}/forum/{{ $forum->slug }}">Cancel</a>
          </div>
    
          {{ Form::close() }}
        </div>

      </div>

    </div>

  </div>
</section>

@include('layout.footer')