@include('layout.header')

<section id="forum" class="topic-view">
  <div class="container">

    <div class="content">

      <ul class="breadcrumb">
        <li><a href="{{ URL::base() }}/forum">Forums</a> <span class="divider">&rsaquo;</span></li>
        <li><a href="{{ URL::base() }}/forum/{{ $forum->slug }}">{{ $forum->name }}</a> <span class="divider">&rsaquo;</span></li>
        <li class="active">{{ $topic->name }}</li>
  
        @if(Auth::check())
          @if($user->id == $topic->author_id)
          <div class="btn-group pull-right">
            <a href="{{ URL::current() }}/edit" class="btn">Edit</a>
            @if($topic->locked == 0)
            <a href="{{ URL::current() }}/lock" class="btn">Lock</a>
            @else
            <a href="{{ URL::current() }}/unlock" class="btn">Unlock</a>
            @endif
            <a href="{{ URL::current() }}/delete" class="btn btn-danger">Delete</a>
          </div>
          @endif
        @endif
      </ul>

      <hr/>

      <div class="topic-title">
        <img src="{{ Load::avatar($topic->author->avatar, $topic->author->id) }}" class="pull-left rounded">
      
        <div class="pull-left">
          <h2>{{ $topic->name }}
            @if($topic->locked == 1)
              <span class="label label-important">LOCKED</span>
            @endif
          </h2>
          by <a href="{{ URL::base() }}/user/{{ $topic->author->username }}">{{ $topic->author->first_name }} {{ $topic->author->last_name }}</a> &#8226; {{ Utilities::timeAgo($topic->timestamp) }}
        </div>
      </div>

      <div class="span8">
        <div class="well">
          {{ Utilities::linkify(nl2br($topic->post)) }}
        </div>
      
        <hr/>
      </div>

      <section id="comments" class="span8">
      
        @if($posts)
      
        <div class="comment">
      
          @foreach($posts as $post)
      
          <div class="single-comment">
      
            <a class="avatar" href="{{ URL::base() }}/user/{{ $post->username }}" rel="tooltip" title="{{ $post->first_name }} {{ $post->last_name }}">
              <img src="{{ Load::avatar($post->avatar, $post->uid) }}" />
            </a>
      
            <div class="message">
              @if(Auth::check())
                @if($user->id == $post->author_id)
                <a class="close" href="{{ URL::current() }}/c-{{ $post->post_id }}/delete">&times;</a>
                @endif
              @endif
        
              <span>{{ Utilities::linkify(nl2br($post->post)) }}</span>
              
              <div class="time">
                <!--{{ $post->first_name }} {{ $post->last_name }}-->
                <span>{{ Utilities::timeAgo($post->timestamp) }}</span>
              </div>
            </div>
      
          </div>
      
          @endforeach
      
        </div>
      
        @else
        <div class="comment">
          There are no replies.
        </div>
        @endif

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
      
          <textarea placeholder="Add a reply" id="input01" name="reply" id="comment_content"></textarea>
      
          <button type="submit" class="btn pull-right" id="add_comment">Reply</button>
        </div>
        {{ Form::close() }}
      
        @endif

      </section>

    </div> <!-- .content -->

  </div>
</section>

@include('layout.footer')