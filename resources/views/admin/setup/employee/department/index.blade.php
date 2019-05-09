@php
	$route = 'setup.employee.department.';
	$lang = 'setup.employee.department.';
	$page = 'Department';
	$js = ['setup/employee/department'];
@endphp
@extends('layouts.master', ['title' => __($lang.'title'), 'modal' => true])
@section('page.header')
<div class="page-header page-header-light">
	<div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
		<div class="d-flex">
			<div class="breadcrumb">
				<a href="{{ route('home') }}" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> @lang('trt.home')</a>
				<span class="breadcrumb-item active">@lang($lang.'title')</span>
			</div>
			<a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
		</div>
	</div>
</div>
@stop
@section('content')
<!-- Basic initialization -->
<div class="card">
	<div class="card-header header-elements-inline">
		<h5 class="card-title">@lang($lang.'title')
		@can('create-employee_department')
		<button type="button" class="btn btn-link" data-toggle="modal" data-target="#modal_remote" id="content_managment" data-url="{{route($route.'create')}}"><i class="icon-stack-plus mr-2"></i> @lang($lang.'create')</button>
		@endcan
		</h5>
		<div class="header-elements">
			<div class="list-icons">
				<a class="list-icons-item" data-action="collapse"></a>
			</div>
		</div>
	</div>
	@can('view-employee_department')
	<div class="card-body">
		<table class="table content_managment_table" data-url="{{route($route.'datatable')}}">
			<thead>
				<tr>
					<th>@lang($lang.'table.id')</th>
					<th>@lang($lang.'table.name')</th>
					<th>@lang($lang.'table.description')</th>
					<th>@lang($lang.'table.status')</th>
					<th>@lang($lang.'table.action')</th>
				</tr>
			</thead>
			<tbody>
			</tbody>
		</table>
	</div>
	@endcan
</div>
<!-- /basic initialization -->
@stop
@push('admin.scripts')
<!-- Theme JS files -->
<script src="{{ asset('asset/global_assets/js/plugins/tables/datatables/datatables.min.js') }}"></script>
<script src="{{ asset('asset/global_assets/js/plugins/extensions/jquery_ui/interactions.min.js') }}"></script>
<script src="{{ asset('asset/global_assets/js/plugins/tables/datatables/extensions/jszip/jszip.min.js') }}"></script>
<script src="{{ asset('asset/global_assets/js/plugins/tables/datatables/extensions/pdfmake/pdfmake.min.js') }}"></script>
<script src="{{ asset('asset/global_assets/js/plugins/tables/datatables/extensions/pdfmake/vfs_fonts.min.js') }}"></script>
<script src="{{ asset('asset/global_assets/js/plugins/tables/datatables/extensions/buttons.min.js') }}"></script>
@if ($js != '')
@forelse ($js as $element)
<script src="{{ asset('js/pages/'.$element.'.js') }}"></script>
@empty
@endforelse
@endif
<!-- /theme JS files -->
@endpush