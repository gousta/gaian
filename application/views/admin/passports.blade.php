@include('admin.layout.header')

<div class="container">

	<ul class="breadcrumb">
		<li><a href="/admin">Admin</a> <span class="divider">/</span></li>
		<li class="active">Passports</li>
	</ul>

	<table class="table table-bordered table-hover">
		<tbody>
		@foreach($people->results as $user)
			<tr>
				<td style="width: 30px;vertical-align: middle"><img src="{{ Load::avatar($user->avatar, $user->id) }}" style="width: 30px;height: 30px;border-radius: 3px;"></td>
				<td style="vertical-align: middle"><a href="{{ URL::base() }}/user/{{ $user->username }}" target="_blank">{{ $user->username }}</a></td>
				<td style="vertical-align: middle">{{ $user->first_name }} {{ $user->last_name }}</td>
				<td style="vertical-align: middle"><a href="mailto:{{ $user->email }}">{{ $user->email }}</a></td>
				<td style="width: 80px;vertical-align: middle">
					<div class="btn-group">
            <a href="/admin/passports/edit/{{ $user->id }}" class="btn">Edit</a>
            <button class="btn dropdown-toggle" data-toggle="dropdown"><i class="icon-caret-down"></i></button>
            <ul class="dropdown-menu">
              <li><a href="/admin/passports/delete/{{ $user->id }}"><i class="icon-remove"></i> Delete</a></li>
            </ul>
          </div>
				</td>
			</tr>
		@endforeach
		</tbody>
	</table>
	
	
	{{ $people->links() }}

</div>

@include('admin.layout.footer')