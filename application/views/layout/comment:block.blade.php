<section id="comments">

  @if(Auth::check())

  @if ($errors->all())
  <div class="alert alert-error">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <b>Oh snap!</b>
    @foreach ($errors->all() as $error)
    <span>{{ $error }}</span>
    @endforeach
  </div>
  @endif

  {{ Form::open(null, 'POST', array('class' => 'form-horizontal')) }}
  <div class="comment">
    <div class="avatar">
      <img src="{{ Load::avatar() }}" />
    </div>

    <textarea placeholder="Place your comment here" name="comment" id="comment_content"></textarea>

    <button type="submit" class="btn pull-right" id="add_comment">Add comment</button>
  </div>
  {{ Form::close() }}

  @else

  <div class="comment">
    @if(Auth::guest())
    <span class="guest"><a class="btn btn-small" href="/join">Join us</a> to add a comment</span>
    @endif
  </div>

  @endif

  @if($comments)

  <div class="comment">

    @foreach ($comments as $comment)

    <div class="single-comment">

      <a class="avatar" href="{{ URL::base() }}/user/{{ $comment->username }}" rel="tooltip" title="{{ $comment->first_name }} {{ $comment->last_name }}">
        <img src="{{ Load::avatar($comment->avatar, $comment->uid) }}" />
      </a>

      <div class="message">
        @if(Auth::check())
          @if($user->id == $comment->author)
          <a class="close" href="{{ URL::current() }}/c-{{ $comment->id }}/delete">&times;</a>
          @endif
        @endif
  
        <span>{{ Utilities::linkify(nl2br($comment->comment)) }}</span>
        
        <div class="time">
          <span>{{ Utilities::timeAgo($comment->timestamp) }}</span>
        </div>
      </div>

    </div>

    @endforeach

  </div>

  @endif

</section>