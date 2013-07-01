<div class="span3 gaianshot">
  @if($user->avatar != '')
    <a href="{{ URL::base() }}/settings/avatar/delete"><i class="icon-trash"></i></a>
  @endif
  <img src="{{ Load::avatar(null, null, 'normal') }}" class="thumbnail">
  
  @if($user->avatar == '')
  
    {{ Form::open_for_files('settings/avatar', 'POST', array('id' => 'upload_form')) }}

    <div id="input">
      <span class="btn btn-large"><i class="icon-upload-alt"></i> Upload picture
        <input id="file" name="file" type="file">
      </span>
    </div>

    <div id="loading" style="display:none; text-align:center; width: 190px;">
      <img src="/assets/img/loader.small.gif">
    </div>

    {{ Form::close() }}

  @endif

  @if(Session::has('error'))<br/>
    <div class="alert alert-error" style="width: 139px;">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
      {{ Session::get('error') }}
    </div>
  @endif

  @if(Session::has('success'))<br/>
    <div class="alert alert-success" style="width: 139px;">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
      {{ Session::get('success') }}
    </div>
  @endif
</div>

<div class="navbar span9">
  <div class="navbar-inner">
    <a class="brand" href="{{ URL::base() }}/settings/"><i class="icon-cogs"></i></a>

    <ul class="nav">
      <li><a href="{{ URL::base() }}/settings/personal">Personal</a></li>
      <li><a href="{{ URL::base() }}/settings/regional">Regional</a></li>
      <li><a href="{{ URL::base() }}/settings/apps">Applications</a></li>
      <li><a href="{{ URL::base() }}/settings/password">Password</a></li>
    </ul>

    <ul class="nav pull-right">
      <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Advanced <i class="icon-chevron-down"></i></a>

        <ul class="dropdown-menu">
          <li><a href="{{ URL::base() }}/settings/delete">Delete account</a></li>
        </ul>
      </li>
    </ul>

  </div>
</div>