@php
$route = 'setup.configuration.';
$lang = 'setup.employee.general.';
$js = ['setup/employee/general'];
@endphp
@extends('layouts.master', ['title' => __($lang.'title'), 'modal' => false])
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
        </h5>
        <div class="header-elements">
            <div class="list-icons">
                <a class="list-icons-item" data-action="collapse"></a>
            </div>
        </div>
    </div>
    @can('create-employee')
    <div class="card-body">
        {!! Form::model($config, ['route' => [$route.'store'], 'class' => 'form-validate-jquery', 'id' => 'content_form', 'method' => 'POST', 'files' => true]) !!}
        <fieldset class="mb-3">
            <legend class="text-uppercase font-size-sm font-weight-bold">{{__($lang.'create')}} <span class="text-danger">*</span> <small> @lang('trt.required') </small></legend>
            <div class="form-group row">
                {{ Form::label('employee_code_prefix', __($lang.'form.prefix_label') , ['class' => 'col-form-label col-lg-4 text-right']) }}
                <div class="col-lg-8">
                    {{ Form::hidden('config_type', 'employee' ) }}
                    {{ Form::text('employee_code_prefix', Null, ['class' => 'form-control', 'placeholder' =>  __($lang.'form.prefix') ]) }}
                </div>
            </div>
            <div class="form-group row">
                {{ Form::label('employee_code_digit', __($lang.'form.code_digit_label') , ['class' => 'col-form-label col-lg-4 text-right']) }}
                <div class="col-lg-8">
                    {{ Form::text('employee_code_digit', Null, ['class' => 'form-control', 'placeholder' =>  __($lang.'form.code_digit'), 'data-parsley-type' => 'number']) }}
                </div>
            </div>
            <div class="mt-3">
                <div class="form-group row">
                    <div class="col-lg-4 offset-lg-4">
                        {{ Form::submit(__('trt.form.save'), ['class' => 'btn btn-primary ml-3l', 'id' => 'submit']) }}
                        <button type="button" class="btn btn-link" id="submiting" style="display: none;">Submiting <img src="{{ asset('asset/ajaxloader.gif') }}"></button>
                    </div>
                </div>
            </div>
        </fieldset>
        {!! Form::close() !!}
        @push('admin.scripts')
        @endpush
    </div>
    @endcan
</div>
<!-- /basic initialization -->
@stop
@push('admin.scripts')
<!-- Theme JS files -->
<script src="{{ asset('asset/global_assets/js/plugins/extensions/jquery_ui/interactions.min.js') }}"></script>
<script src="{{ asset('asset/global_assets/js/plugins/extensions/jquery_ui/widgets.min.js') }}"></script>
<script src="{{ asset('asset/global_assets/js/plugins/extensions/jquery_ui/effects.min.js') }}"></script>
@if ($js != '')
@forelse ($js as $element)
<script src="{{ asset('js/pages/'.$element.'.js') }}"></script>
@empty
@endforelse
@endif
<!-- /theme JS files -->
@endpush