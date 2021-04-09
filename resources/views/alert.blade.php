@if($msg = Session::get('success'))
<div class="alert alert-success">
  {{ $msg }}
</div>
@endif
@if($msg = Session::get('error'))
<div class="alert alert-danger">
  {{ $msg }}
</div>
@endif