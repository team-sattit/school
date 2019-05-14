<img src="{{ asset('asset/ajaxloader.gif') }}" id="delete_loading_{{$model->id}}" style="display: none;">
<div class="list-icons" id="action_menu_{{$model->id}}">
	<div class="dropdown">
		<a href="#" class="list-icons-item" data-toggle="dropdown">
			<i class="icon-menu9"></i>
		</a>
		<div class="dropdown-menu dropdown-menu-right">
			@can('view'.$permission)
			<a class="dropdown-item" href="{{ route($route.'show', $model->uuid )}}"><i class="icon-eye"></i> @lang('trt.action.view')</a>
			@endcan
			@can('update'.$permission)
			<a class="dropdown-item" href="{{ route($route.'edit', $model->uuid )}}"><i class="icon-pencil7"></i> @lang('trt.action.edit')</a>
			@endcan
			{{-- @can('change-status'.$permission)
			<span class="dropdown-item" id="change_status" data-id="{{ $model->id }}" data-status="{{ $model->status }}" data-url="{{ route($route.'status', $model->uuid )}}"><i class="icon-station"></i> @lang('trt.action.change_status')</span>
			@endcan --}}
			@can('delete'.$permission)
			<span class="dropdown-item" id="delete_item" data-id="{{ $model->id }}" data-url="{{ route($route.'destroy', $model->uuid )}}"><i class="icon-trash"></i> @lang('trt.action.delete') </button></span>
			@endcan
		</div>
	</div>
</div>