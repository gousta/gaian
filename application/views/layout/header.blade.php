<!--
/******************************************
*
*  Welcome on the Gaian.me community site!
*  
*  Designer: Marius Bauer http://www.mariusbauer.com
*  BackEnd: Stratos Giouldasis - http://www.giouldasis-stratos.com
*  FrontEnd: Chris Krupski - http://zerply.com/Clu
*
*  Built using some of the latest web technologies:
*  http://laravel.com
*  http://twitter.github.com/bootstrap/
*
*******************************************/
-->
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

  <title>{{ $title }}</title>
  <meta name="description" content="This is our new platform — a gathering place and a growing toolkit for Gaians to creatively and collaboratively engage with each other, our communities, and our world." />
	<meta name="keywords" content="gaian.me,gaian,gaia10,gaia11,gaia12,gaia13,gaian me,gaia,celebrate,beauty,nature," />
		
	<meta property="og:title" content="{{ $title }}" />
	<meta property="og:description" content="This is our new platform — a gathering place and a growing toolkit for Gaians to creatively and collaboratively engage with each other, our communities, and our world." />
	<meta property="og:type" content="website" />
	<meta property="og:url" content="{{ URL::current() }}" />
	<meta property="og:site_name" content="Gaian.me" />
	<meta property="fb:app_id" content="405915736131452">
	
  @if ($item->id !== null)
  <meta property="og:image" content="{{ Config::get('path.media.url') }}{{ $item->id }}/large.jpg">
  @endif

  <link rel="shortcut icon" href="{{ URL::base() }}/assets/img/favicon.png">

  <meta name="viewport" content="width=device-width, initial-scale=0.65, maximum-scale=0.65">

  @if (URL::current() == URL::base() . '/')
    {{ HTML::style('assets/css/main.css') }}
  @else
    {{ HTML::style('assets/css/app.css') }}
  @endif
  
  {{ HTML::script('assets/js/vendor/modernizr.custom.02356.js') }}
</head>

<body
  @if($nomenu)
    class="hide-elements"
  @elseif ($homepage)
    class="homepage"
  @endif
>
  <!--[if lt IE 7]>
    <p class="chromeframe">Your browser is <em>ancient!</em> <a href="http://browsehappy.com/">Upgrade to a different browser</a>
    or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to experience this site.</p>
  <![endif]-->

  <div id="gaian-panel">
    <div class="container">

      <div class="row-fluid">

        <div class="span2">
          <h5>Join us</h5>
      
          <a href="{{ URL::base() }}/join" class="btn btn-large btn-green">Sign up</a>
          <a href="{{ URL::base() }}/connect/facebook" class="btn btn-large btn-facebook"><i class="icon-facebook-sign"></i> Connect</a>

          <a href="#" class="close">or close this</a>
        </div>

        <div class="span6">
          <h2>Celebrate, comment<br/> and show some love.</h2>
        </div>

        <div class="span4">
          {{ Form::open('sign-in', 'POST') }}
          
            <h5>Sign in</h5>

            <div class="control-group">
              <div class="controls">
                <input type="text" placeholder="Email" id="input01" name="email">
              </div>
            </div>
            
            <div class="control-group">            
              <div class="controls">
                <input type="password" placeholder="Password" id="input01" name="password">
              </div>
            </div>
  
            <label class="checkbox pull-left">
              <input type="checkbox" name="remember" checked="checked"> Remember me
            </label>
            <button type="submit" class="btn pull-right">Sign in</button>

          {{ Form::close() }}
        </div>

      </div>

    </div>
  </div>

  <header id="globalhead">
    <div class="container">

      <a id="logo" href="/">Gaian</a>

      <nav id="globalnav">
        <ul>
          <li><a href="{{ URL::base() }}/discover">Discover</a></li>
          @if(Auth::guest())
          <li><a href="{{ URL::base() }}/join">Get involved</a></li>
          @endif
          <li><a href="{{ URL::base() }}/forum">Forum</a></li>
        </ul>
      </nav>

      <form id="search" action="/search" method="GET">
        <input type="search" placeholder="Search" class="search-query" data-provide="typeahead" name="query" value="{{ Input::get('query') }}">
      </form>

      <div id="social-menu">
      
      	@if ($homepage)
        <div class="fb-like" data-href="http://www.facebook.com/gaianme" data-send="false" data-layout="button_count" data-show-faces="false" data-font="lucida grande"></div>
        <a href="https://twitter.com/share" class="twitter-share-button" data-lang="en" data-url="{{ URL::base() }}">Tweet</a>
        @endif

        @if(Auth::guest())
          <a href="#" class="ribbon-login">Sign in</a>
        @endif

        @if(Auth::check())

        <div class="sm-user">
          <div class="inner">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="{{ Load::avatar() }}">
              <i class="icon-chevron-down"></i>
            </a>
  
            <ul class="dropdown-menu pull-right" role="menu" aria-labelledby="dropdownMenu">
              <li><a tabindex="-1" href="/contribute"><i class="icon-share-alt"></i> Contribute to Gaia</a></li>
              <li class="divider"></li>
              <li><a tabindex="-1" href="/user/{{ Auth::user()->username }}"><i class="icon-cloud"></i> Profile</a></li>
              <li><a tabindex="-1" href="/settings/"><i class="icon-cogs"></i> Account Settings</a></li>
              <li class="divider"></li>
              @if(Auth::user()->role == 4)
              	<li><a tabindex="-1" href="/admin"><i class="icon-dashboard"></i> Dashboard</a></li>
              	<li class="divider"></li>
              @endif
              <li><a tabindex="-1" href="/sign-out"><i class="icon-signout"></i> Sign out</a></li>
            </ul>
          </div>
        </div>

        @endif
      </div>

    </div>
    
  </header>