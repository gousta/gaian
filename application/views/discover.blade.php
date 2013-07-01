@include('layout.header')

  <section id="discover">
    <div class="container">

      <div class="btn-group">
        <a href="/discover/wallpaper" class="btn">Wallpapers</a>
        <a href="/discover/theme" class="btn">Themes</a>
        <a href="/discover/music" class="btn">Music</a>
        <a href="/discover/icons" class="btn">Icons</a>
        <a href="/discover/tools" class="btn">Tools</a>
      </div>

      <br/>

      <div id="artworks-wall" class="row">
        <div class="thumbnails">
  
        @foreach ($data as $item)
  
        <div class="span4 artwork">
          <a class="thumbnail" href="{{ URL::base() }}/discover/{{ $item->category   }}/{{ $item->id }}">
            <img src="{{ Config::get('path.media.url') }}{{ $item->id }}/wide.jpg" alt="{{ $item->title }}" />
          </a>
  
          <div class="description">
  
            <div class="row-fluid">
              <div class="span10">
                <span class="work-info">{{ $item->title }} <a href="{{ URL::base() }}/user/{{ $item->username }}">by {{ $item->first_name }} {{ $item->last_name }}</a></span>
              </div>
  
              <div class="span2">
                <!--<span class="likes-count">0 <i class="icon-eko-dark"></i></span>-->
              </div>
            </div>
            
          </div>
        </div>
  
        @endforeach

        </div>
      </div>

    </div>
  </section>

  

@include('layout.footer')