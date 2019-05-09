@if (session('success'))
<span class="d-block text-muted alert alert-success text-center" role="alert">{{session('success')}}</span>
@elseif(session('warning'))
<span class="d-block text-muted alert alert-warning text-center" role="alert">{{session('warning')}}</span>
@elseif(session('danger'))
<span class="d-block text-muted text-center alert alert-danger" role="alert">{{session('danger')}}</span>
@endif