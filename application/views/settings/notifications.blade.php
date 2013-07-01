@if ($errors->all())
<div class="alert alert-error">
  <button type="button" class="close" data-dismiss="alert">&times;</button>
    <strong>Oh snap!</strong>
    <ul>
    @foreach ($errors->all() as $error)
      <li>{{ $error }}</li>
    @endforeach
    </ul>
</div>
@endif