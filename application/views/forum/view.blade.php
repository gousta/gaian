@include('layout.header')

<section id="forum" class="topics">
  <div class="container">

    <div class="content">

      <h2>{{ $forum->name }}</h2>
      
      <hr/>

      <div class="row-fluid">
        <ul class="breadcrumb @if (Auth::check()) span10 @endif">
          <li>
            <a href="{{ URL::base() }}/forum">Forums</a> <span class="divider">&rsaquo;</span>
          </li>
          <li class="active">{{ $forum->name }}</li>
        </ul>
  
        @if (Auth::check())
        <div class="span2">
          <a href="{{ URL::base() }}/forum/{{ $forum->slug }}/create" class="btn btn-large btn-warning"><i class="icon-edit"></i> Add Topic</a>
        </div>
        @endif
      </div>

      <hr/>

      <table class="table table-bordered">
        <thead>
          <tr>
            <th class="cat">Topics</th>
            <th class="top counts">Replies</th>
            <th class="post counts">Views</th>
            <th class="rec">Recent activity</th>
          </tr>
        </thead>

        <tbody>
          @foreach($topics as $topic)
          <tr>
            <td>
              @if($topic->locked == 1)
                <i class="icon-lock"></i>
              @endif
                <a class="post-title" style="color: #333" href="{{ URL::base() }}/forum/{{ $forum->slug }}/{{ $topic->slug }}">{{ $topic->name }}</a>
                <div style="font-size: 12px;color:#999">By {{ $topic->author->first_name }} {{ $topic->author->last_name }}</div>
            </td>
            <td class="counts">{{ $topic->replies }}</td>
            <td class="counts">{{ $topic->views }}</td>
            <td>
              @if($topic->activity != '')
              <a class="post-title" href="{{ URL::base() }}/forum/{{ $forum->slug }}/{{ $topic->slug }}"><i class="icon-comment"></i> {{ Utilities::truncate($topic->activity->post) }}</a>
              <span class="activity">By {{ $topic->activity->first_name }} {{ $topic->activity->last_name }} &#8226; {{ Utilities::timeAgo($topic->activity->timestamp) }}</span>
              @else
              <span class="activity">No activity</span>
              @endif
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>

    </div>

  </div>
</section>

@include('layout.footer')