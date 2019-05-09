@if ($model->status == 1)
<span class="badge badge-success">@lang('trt.status.active')</span>
@endif
@if ($model->status == 0)
<span class="badge badge-warning">@lang('trt.status.inactive')</span>
@endif