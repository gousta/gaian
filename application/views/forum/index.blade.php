@include('layout.header')

<section id="forum">
  <div class="container">

    <div class="content">

      <h1>Forums</h1>
      
      <hr/>

      <ul class="breadcrumb">
        <li>
          <a href="{{ URL::base() }}/forum">Forums</a> <span class="divider">&rsaquo;</span>
        </li>
        <li class="active">Index</li>
      </ul>

      <hr/>

      @foreach($forumdata as $category => $forums)
      
      <table class="table table-bordered">
        <thead>
          <tr>
            <th class="cat">{{ $category }}</th>
            <th class="top counts">Topics</th>
            <th class="post counts">Posts</th>
            <th class="rec">Recent activity</th>
          </tr>
        </thead>

        <tbody>
          @foreach($forums as $forum)
          <tr>
            <td><a class="post-title" href="{{ URL::base() }}/forum/{{ $forum->slug }}">{{ $forum->name }}</a></td>
            <td class="counts">{{ $forum->topic_count }}</td>
            <td class="counts">{{ $forum->post_count }}</td>
            <td>
              @if($forum->topic_count > 0)
              <a class="post-title" href="{{ URL::base() }}/forum/{{ $forum->slug }}/{{ $forum->activity->slug }}">{{ $forum->activity->name }}</a>
              <span class="activity">By {{ $forum->activity->first_name }} {{ $forum->activity->last_name }} &#8226; {{ Utilities::timeAgo($forum->activity->timestamp) }}</span>
              @else
              <span class="activity">No activity</span>
              @endif
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
      
      @endforeach

    </div>

  </div>
</section>

@include('layout.footer')