@include('layout.header')

<section id="profile">
  <div class="container">

    <div class="content">

      {{-- PROFILE HEAD --}}
      <div class="profile-head board-window">
        <img src="{{ Load::avatar($swarm->avatar, $swarm->id, 'normal') }}" class="thumbnail" width="160px">

        <!--
        <ul class="nav nav-tabs">
          <li class="active">
            <a href="#"><i class="icon-cloud"></i> Profile</a>
          </li>
          <li><a href="#"><i class="icon-leaf"></i> Gallery</a></li>
          <li><a href="#"><i class="icon-heart"></i> Favourites</a></li>
        </ul>
        -->

        <div class="board-title">
          <hgroup>
            <h1>{{ $swarm->name }}</h1>
            <h4>{{ ucfirst($swarm->cause) }}</h4>
          </hgroup>
        </div>
      </div>

      <hr/>

      {{-- PROFILE BODY --}}
      <div class="row-fluid">

        {{-- COMMENTS --}}
        <div class="span7">
          @include('layout.comment:block')
        </div>

        {{-- GAIANS - SWARMS --}}
        <div class="row-fluid span5">

          <div class="board-window">
            <div class="board-title">
              <h4><i class="icon-cloud"></i> Gaians</h4>
            </div>
  
            <div class="board-content thumbs">
              <ul class="thumbnails">
              @forelse($gaians as $gaian)
                <li>
                  <a href="{{ URL::base() }}/user/{{ $gaian->username }}" title="{{ $gaian->first_name }} {{ $gaian->last_name }}" class="thumbnail ttip">
                    <img src="{{ Load::avatar($gaian->avatar, $gaian->id) }}">
                  </a>
                </li>
              @empty
                <span class="empty">None</span>
              @endforelse
              </ul>

              <!--
              @if($gaiansnum > 3)
                <a class="btn" href="#" data-toggle="modal" data-path="/load/gaians/{{ $swarm->id }}">See All</a>
              @endif
              -->
            </div>
          </div>

        </div>
      </div>

    </div>

  </div>
</section>

@include('layout.footer')