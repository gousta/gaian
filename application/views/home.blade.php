@include('layout.header')

  <div id="hero-board">
  	<iframe class="vimeo" src="http://player.vimeo.com/video/49594235?title=0&amp;byline=0&amp;portrait=0" width="1067" height="450" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
  </div>

  <section id="star-contribs">

    <div id="hgroup">
      <div class="container">
        <h5>Contributions we love <a href="{{ URL::base() }}/discover">Discover more!</a></h5>
      </div>
    </div>

    <div id="show-contribs">
      <div class="container">

        <div class="row-fluid">

          @foreach ($celebrated as $item)
          <?php $i++; ?>
          <div class="span3" <?php echo ($i == 5 || $i == 9 || $i == 13) ? 'style="margin-left:0;height: 140px"':'style="height: 150px"'; ?>>
            <a class="thumb" href="{{ URL::base() }}/discover/{{ $item->id }}">
              <img src="{{ Config::get('path.media.url') }}{{ $item->id }}/wide.jpg" style="border:none" />
            </a>

            <div class="description">

              <div class="row-fluid">
                <div class="span12">
                  <span class="work-info">{{ $item->title }} <a href="{{ URL::base() }}/user/{{ $item->username }}">by {{ $item->first_name }} {{ $item->last_name }}</a></span>
                </div>

                <!--<div class="span3">
                  <span class="likes-count">0 <i class="icon-eko"></i></span>
                </div>-->
              </div>
              
            </div>
          </div>

          @endforeach

        </div>
      </div>

    </div>

  </section>

  <section id="community-wall">
    <div class="container">

      <div class="hgroup">
        <h5>Our awesome community contributions <a href="" class="disabled">how does this work?</a></h5>
        <a href="http://thrives.us/" target="_blank" class="logo-thrives">thrives</a>
      </div>

      <ul class="thumbnails">

        @foreach ($feed as $item)

          <li class="span2">
            <a href="{{ $item->link }}" target="_blank">
              <img src="{{ $item->image }}" width="100" height="100" />
              <span>{{ $item->user_username }}</span>
            </a>
          </li>

        @endforeach

      </ul>

      <hr/>

    </div>
  </section>
<!--
  <div class="loadmore">
    <a href="" class="btn btn-large">load more <i class="icon-play"></i></a>
  </div>
-->
@include('layout.footer')