
@if (isActiveEmployee($model))
<span class="badge badge-success">@lang('trt.status.active')</span>
@else
<span class="badge badge-warning">@lang('trt.status.inactive')</span>
@endif