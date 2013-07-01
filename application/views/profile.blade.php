@include('layout.header')

<section id="profile">
  <div class="container">

    <div class="content">

      {{-- PROFILE HEAD --}}
      <div class="profile-head board-window">
        <img src="{{ Load::avatar($profile->avatar, $profile->id, 'normal') }}" class="thumbnail" width="160px">

        <ul class="nav nav-tabs">
          <li class="active">
            <a href="#"><i class="icon-cloud"></i> Profile</a>
          </li>
          <!--<li><a href="#"><i class="icon-leaf"></i> Gallery</a></li>
          <li><a href="#"><i class="icon-heart"></i> Favourites</a></li>-->
        </ul>

        <div class="board-title">
          <hgroup>
            <h1>{{ $profile->first_name }} {{ $profile->last_name }}&nbsp;</h1>
            <h4>{{ ucfirst($profile->social_status) }} {{ ($profile->city || $profile->country) ? 'from':null }} {{ ($profile->city) ? $profile->city.',':null }} {{ $profile->country }}&nbsp;</h4>
          </hgroup>
        </div>
      </div>
      <!--
      @if(Auth::user()->pro == '1')
        <div class="control-group">
          <label class="control-label" for="input05">Upgrade to Pro!</label>

          <div class="controls">
            

            {{ Form::open('https://www.sandbox.paypal.com/cgi-bin/webscr', 'POST', array('style'=>'margin:0', 'class'=>'buyForm3')) }}
         
              <input type="hidden" name="cmd" value="_xclick">
              <input type="hidden" name="business" value="5DYQT2YDVF32J">
              <input type="hidden" name="lc" value="GR">
              <input type="hidden" name="item_name" value="Upgrade">
              <input type="hidden" name="item_number" value="pro">
              <input type="hidden" name="amount" value="1.00">
              <input type="hidden" name="currency_code" value="EUR">
              <input type="hidden" name="button_subtype" value="services">
              <input type="hidden" name="return" value="{{ URL::base() }}/order-complete">
              <input type="hidden" name="cancel_return" value="{{ URL::base() }}">
              <input type="hidden" name="bn" value="PP-BuyNowBF:btn_buynowCC_LG.gif:NonHosted"


            
            
          </div>  
          <div class="boxes">
            <button class="btn pull-left">Upgrade</button>
          {{ Form::close() }}
          </div>
        </div>
      @endif
      -->
      <hr/>

      {{-- PROFILE BODY --}}
      <div class="row-fluid">

        {{-- COMMENTS --}}
        <div class="span7">
          @include('layout.comment:block')
        </div>

        {{-- GAIANS - SWARMS --}}
        <div class="row-fluid span5">
        	
        	

          {{-- ACTIVITY --}}
          <div class="board-window">
            <div class="board-title">
              <h4><i class="icon-heart"></i> Activity</h4>
            </div>
  
            <div class="board-content">
              <div class="progress progress-striped">
                <div class="bar" style="width: {{ $user_activity/$top_activity*100 }}%">{{ round($user_activity/$top_activity*100) }}%</div>
              </div>
            </div>
          </div>

<!--
          <div class="board-window">
            <div class="board-title">
              <h4><i class="icon-user"></i> More about me</h4>
            </div>
  
            <div class="board-content thumbs">
              <table class="about-me">
                <tbody>
                  <tr>
                    <th>Website</th>
                    <td><a href="#" target="_blank">www.website.com</a></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
-->
<!--
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

              
              @if($gaiansnum > 3)
                <a class="btn" href="#" data-toggle="modal" data-path="/load/gaians/{{ $profile->id }}">See All</a>
              @endif
            </div>
          </div>
-->

<!--           <div class="board-window">
            <div class="board-title">
              <h4><i class="icon-flag"></i> Swarms</h4>
            </div>
  
            <div class="board-content thumbs">
              <ul class="thumbnails">
              @forelse($swarms as $swarm)
                <li>
                  <a href="{{ URL::base() }}/swarm/{{ $swarm->custom_name }}" title="{{ $swarm->name }}" class="thumbnail ttip">
                    <img src="{{ Load::avatar($swarm->avatar, $swarm->id) }}">
                  </a>
                </li>
              @empty
                <span class="empty">None</span>
              @endforelse
              </ul>

              <!--
              @if($swarmsnum > 3)
                <a class="btn" href="#" data-toggle="modal" data-path="/load/swarms/{{ $profile->id }}">See All</a>
              @endif
              
            </div>
          </div>
 -->
          {{-- CONTRIBUTIONS --}}
          <div class="board-window">
            <div class="board-title">
              <h4><i class="icon-leaf"></i> Contributions</h4>
            </div>
  
            <div class="board-content thumbs">
              <ul class="thumbnails contribs">
              @forelse ($related as $relitem)
                <li>
                  <a href="{{ URL::base() }}/discover/{{ $relitem->id }}" class="thumbnail">
                    <img src="{{ Config::get('path.media.url') }}{{ $relitem->id }}/thumb.jpg" width="84px" />
                  </a>
                </li>
              @empty
                <span class="empty">{{ $profile->first_name }} hasn't contributed to Gaia yet.</span>
              @endforelse
              </ul>
            </div>
          </div>

        </div>
      </div>

    </div>

  </div>
</section>

@include('layout.footer')