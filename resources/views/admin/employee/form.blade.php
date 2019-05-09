@php
$route = 'employee.';
$lang = 'employee.';
$js = ['employee/employee_form'];
$prefix = config('trt.employee_code_prefix');
$code_digit = config('trt.employee_code_digit');
$code = 0;
foreach ($codes as $key => $value) {
    if ($prefix and $value->prefix == $prefix) {
        $code = $value->code + 1;
        break;
    }
    $code = $value->code + 1;
}
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
        @can('view-employee')
        <a class="btn btn-link" href="{{route($route.'index')}}"><i class="icon-list2 mr-2"></i> @lang($lang.'view')</a>
        @endcan
        </h5>
        <div class="header-elements">
            <div class="list-icons">
                <a class="list-icons-item" data-action="collapse"></a>
            </div>
        </div>
    </div>
    @can('create-employee')
    <div class="card-body">
        @if(isset($model))
        {!! Form::model($model, ['route' => [$route.'update', $model->id], 'class' => 'form-validate-jquery', 'id' => 'content_form', 'method' => 'PUT', 'files' => true]) !!}
        @else
        {!! Form::open(['route' => $route.'store', 'class' => 'form-validate-jquery', 'id' => 'content_form', 'files' => true, 'method' => 'POST']) !!}
        @endif
        <fieldset class="mb-3">
            <legend class="text-uppercase font-size-sm font-weight-bold">{{isset($model) ? __($lang.'update') : __($lang.'create')}} <span class="text-danger">*</span> <small> @lang('trt.required') </small></legend>
            <div id="jui-accordion-collapsible" data-fouc>
                <span class="font-weight-semibold">{{__('trt.employee_form.section1')}}</span>
                <div style="background-color: #f5f5f5; ">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group row">
                                {{ Form::label('prefix', __($lang.'form.id') , ['class' => 'col-form-label col-lg-4 text-right required']) }}
                                <div class="col-lg-3">
                                    {{ Form::text('prefix', $prefix, ['class' => 'form-control', 'placeholder' =>  __($lang.'form.prefix')]) }}
                                </div>
                                <div class="col-lg-5">
                                    {{ Form::text('code', trt_sprintf($code, $code_digit), ['class' => 'form-control', 'placeholder' =>  __($lang.'form.code'), 'required' => '', 'id' => 'code']) }}
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group row">
                                {{ Form::label('branch_id', __($lang.'form.branch_label') , ['class' => 'col-form-label col-lg-4 text-right required']) }}
                                <div class="col-lg-8">
                                    {{ Form::select('branch_id', $branches, Null, ['class' => 'form-control select', 'data-placeholder' =>  __($lang.'form.branch'), 'required' => '', 'data-parsley-errors-container' =>'#bracn_id_error']) }}
                                    <span id="bracn_id_error"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group row">
                                {{ Form::label('department_id', __($lang.'form.department_label') , ['class' => 'col-form-label col-lg-4 text-right required']) }}
                                <div class="col-lg-8">
                                    {{ Form::select('department_id', $departments, Null, ['class' => 'form-control select', 'data-placeholder' =>  __($lang.'form.department'), 'required' => '', 'data-parsley-errors-container' =>'#department_id_error']) }}
                                    <span id="department_id_error"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group row">
                                {{ Form::label('designation_id', __($lang.'form.designation_label') , ['class' => 'col-form-label col-lg-4 text-right required']) }}
                                <div class="col-lg-8">
                                    {!! Form::select('designation_id', $designations, Null, ['class' => 'form-control select', 'data-placeholder' =>  __($lang.'form.designation'), 'required' => '', 'data-parsley-errors-container' =>'#designation_id_error']) !!}
                                    <span id="designation_id_error"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group row">
                                {{ Form::label('joining_date', __($lang.'form.joining_date_label') , ['class' => 'col-form-label col-lg-4 text-right required']) }}
                                <div class="col-lg-8">
                                    {{ Form::text('joining_date', Null, ['class' => 'form-control date', 'placeholder' =>  __($lang.'form.joining_date')]) }}
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group row">
                                {{ Form::label('photo', __($lang.'form.photo_label') , ['class' => 'col-form-label col-lg-4 text-right required']) }}
                                <div class="col-lg-8">
                                    {{ Form::file('photo', ['class' => 'form-control-file', 'placeholder' =>  __($lang.'form.photo'),'accept' => 'image/*']) }}
                                </div>
                            </div>
                        </div>

                    </div>
                    <legend class="text-uppercase font-size-sm font-weight-bold">{{isset($model) ? __($lang.'update') : __($lang.'salary')}} <span id="total_slary_val" class="float-right text-success" style="font-size: 15px"></span></legend>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group row">
                                {{ Form::label('basic_salary', __($lang.'form.basic_salary_label') , ['class' => 'col-form-label col-lg-4 text-right required']) }}
                                <div class="col-lg-8">
                                    {{ Form::text('basic_salary', Null, ['class' => 'form-control', 'placeholder' =>  __($lang.'form.basic_salary'), 'data-parsley-type' => 'number', 'required' => '']) }}
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group row">
                                {{ Form::label('house_rent', __($lang.'form.house_rent_label') , ['class' => 'col-form-label col-lg-4 text-right required']) }}
                                <div class="col-lg-8">
                                    {{ Form::text('house_rent', Null, ['class' => 'form-control', 'placeholder' =>  __($lang.'form.house_rent'), 'required' => '', 'data-parsley-type' => 'number']) }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group row">
                                {{ Form::label('medical_allowance', __($lang.'form.medical_allowance_label') , ['class' => 'col-form-label col-lg-4 text-right required']) }}
                                <div class="col-lg-8">
                                    {{ Form::text('medical_allowance', Null, ['class' => 'form-control', 'placeholder' =>  __($lang.'form.medical_allowance'), 'data-parsley-type' => 'number', 'required' => '']) }}
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group row">
                                {{ Form::label('transport_allowance', __($lang.'form.transport_allowance_label') , ['class' => 'col-form-label col-lg-4 text-right required']) }}
                                <div class="col-lg-8">
                                    {{ Form::text('transport_allowance', Null, ['class' => 'form-control', 'placeholder' =>  __($lang.'form.transport_allowance'), 'required' => '', 'data-parsley-type' => 'number']) }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group row">
                                {{ Form::label('insurance', __($lang.'form.insurance_label') , ['class' => 'col-form-label col-lg-4 text-right required']) }}
                                <div class="col-lg-8">
                                    {{ Form::text('insurance', Null, ['class' => 'form-control', 'placeholder' =>  __($lang.'form.insurance'), 'data-parsley-type' => 'number', 'required' => '']) }}
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group row">
                                {{ Form::label('commission', __($lang.'form.commission_label') , ['class' => 'col-form-label col-lg-4 text-right required']) }}
                                <div class="col-lg-8">
                                    {{ Form::text('commission', Null, ['class' => 'form-control', 'placeholder' =>  __($lang.'form.commission'), 'required' => '', 'data-parsley-type' => 'number']) }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group row">
                                {{ Form::label('extra', __($lang.'form.extra_label') , ['class' => 'col-form-label col-lg-4 text-right required']) }}
                                <div class="col-lg-8">
                                    {{ Form::text('extra', Null, ['class' => 'form-control', 'placeholder' =>  __($lang.'form.extra'), 'data-parsley-type' => 'number', 'required' => '']) }}
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group row">
                                {{ Form::label('overtime', __($lang.'form.overtime_label') , ['class' => 'col-form-label col-lg-4 text-right required']) }}
                                <div class="col-lg-8">
                                    {{ Form::text('overtime', Null, ['class' => 'form-control', 'placeholder' =>  __($lang.'form.overtime'), 'required' => '', 'data-parsley-type' => 'number']) }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <span class="font-weight-semibold">{{__('trt.employee_form.section2')}}</span>
                <div style="background-color: #f5f5f5; ">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group row">
                                {{ Form::label('name', __($lang.'form.name_label') , ['class' => 'col-form-label col-lg-4 text-right required']) }}
                                <div class="col-lg-8">
                                    {{ Form::text('name', Null, ['class' => 'form-control', 'placeholder' =>  __($lang.'form.name'), 'required' => '']) }}
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group row">
                                {{ Form::label('father_name', __($lang.'form.father_name_label') , ['class' => 'col-form-label col-lg-4 text-right required']) }}
                                <div class="col-lg-8">
                                    {{ Form::text('father_name', Null, ['class' => 'form-control', 'placeholder' =>  __($lang.'form.father_name'), 'required' => '']) }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group row">
                                {{ Form::label('mother_name', __($lang.'form.mother_name_label') , ['class' => 'col-form-label col-lg-4 text-right required']) }}
                                <div class="col-lg-8">
                                    {{ Form::text('mother_name', Null, ['class' => 'form-control', 'placeholder' =>  __($lang.'form.mother_name'), 'required' => '']) }}
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group row">
                                {{ Form::label('marital_status', __($lang.'form.marital_status_label') , ['class' => 'col-form-label col-lg-4 text-right']) }}
                                <div class="col-lg-8">
                                    {{ Form::select('marital_status', $marital_statuses, Null, ['class' => 'form-control select', 'data-placeholder' =>  __($lang.'form.marital_status'), 'required' => '', 'data-parsley-errors-container' =>'#marital_status_error']) }}
                                    <span id="marital_status_error"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row" id="married_row" style="display: none;">
                        <div class="col-lg-6">
                            <div class="form-group row">
                                {{ Form::label('spouse_name', __($lang.'form.spouse_name_label') , ['class' => 'col-form-label col-lg-4 text-right required']) }}
                                <div class="col-lg-8">
                                    {{ Form::text('spouse_name', Null, ['class' => 'form-control', 'placeholder' =>  __($lang.'form.spouse_name'), 'readonly' => '']) }}
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group row">
                                {{ Form::label('anniversary_date', __($lang.'form.anniversary_date_label') , ['class' => 'col-form-label col-lg-4 text-right required']) }}
                                <div class="col-lg-8">
                                    {{ Form::text('anniversary_date', Null, ['class' => 'form-control date', 'placeholder' =>  __($lang.'form.anniversary_date'), 'data-parsley-type' => 'date', 'readonly' => '']) }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group row">
                                {{ Form::label('date_of_birth', __($lang.'form.date_of_birth_label') , ['class' => 'col-form-label col-lg-4 text-right required']) }}
                                <div class="col-lg-8">
                                    {{ Form::text('date_of_birth', Null, ['class' => 'form-control date', 'placeholder' =>  __($lang.'form.date_of_birth'), 'data-parsley-type' => 'date', 'required' => '']) }}
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group row">
                                {{ Form::label('gender', __($lang.'form.gender_label') , ['class' => 'col-form-label col-lg-4 text-right required']) }}
                                <div class="col-lg-8">
                                    {{ Form::select('gender', $genders, Null, ['class' => 'form-control select', 'data-placeholder' =>  __($lang.'form.gender'), 'required' => '', 'data-parsley-errors-container' =>'#gender_error']) }}
                                    <span id="gender_error"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group row">
                                {{ Form::label('nid_no', __($lang.'form.nid_no_label') , ['class' => 'col-form-label col-lg-4 text-right required']) }}
                                <div class="col-lg-8">
                                    {{ Form::text('nid_no', Null, ['class' => 'form-control', 'placeholder' =>  __($lang.'form.nid_no'), 'required' => '']) }}
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group row">
                                {{ Form::label('birth_certificate_no', __($lang.'form.birth_certificate_no_label') , ['class' => 'col-form-label col-lg-4 text-right']) }}
                                <div class="col-lg-8">
                                    {{ Form::text('birth_certificate_no', Null, ['class' => 'form-control', 'placeholder' =>  __($lang.'form.birth_certificate_no'), 'data-parsley-type' => 'number']) }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group row">
                                {{ Form::label('nationality_id', __($lang.'form.nationality_label') , ['class' => 'col-form-label col-lg-4 text-right required']) }}
                                <div class="col-lg-8">
                                    {{ Form::select('nationality_id', $nationalities, Null, ['class' => 'form-control select', 'data-placeholder' =>  __($lang.'form.nationality'), 'required' => '', 'data-parsley-errors-container' =>'#nationality_id_error']) }}
                                    <span id="nationality_id_error"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group row">
                                {{ Form::label('religion_id', __($lang.'form.religion_label') , ['class' => 'col-form-label col-lg-4 text-right required']) }}
                                <div class="col-lg-8">
                                    {{ Form::select('religion_id', $religions, Null, ['class' => 'form-control select', 'data-placeholder' =>  __($lang.'form.religion'), 'required' => '', 'data-parsley-errors-container' =>'#religion_id_error']) }}
                                    <span id="religion_id_error"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group row">
                                {{ Form::label('caste_id', __($lang.'form.caste_label') , ['class' => 'col-form-label col-lg-4 text-right']) }}
                                <div class="col-lg-8">
                                    {{ Form::select('caste_id', $castes, Null, ['class' => 'form-control select', 'data-placeholder' =>  __($lang.'form.caste'), 'data-parsley-errors-container' =>'#caste_id_error']) }}
                                    <span id="caste_id_error"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group row">
                                {{ Form::label('category_id', __($lang.'form.category_label') , ['class' => 'col-form-label col-lg-4 text-right']) }}
                                <div class="col-lg-8">
                                    {{ Form::select('category_id', $categories, Null, ['class' => 'form-control select', 'data-placeholder' =>  __($lang.'form.category'), 'data-parsley-errors-container' =>'#category_id_error']) }}
                                    <span id="category_id_error"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <span class="font-weight-semibold">{{__('trt.employee_form.section3')}}</span>
                <div style="background-color: #f5f5f5; ">
                    <div class="row">
                        <div class="col-lg-6">
                            <h5 class="text-center">@lang($lang.'form.present.title')</h3>
                            <div class="form-group row">
                                {{ Form::label('present_house', __($lang.'form.present.house_label') , ['class' => 'col-form-label col-lg-4 text-right required']) }}
                                <div class="col-lg-8">
                                    {{ Form::text('present_house', Null, ['class' => 'form-control', 'placeholder' =>  __($lang.'form.present.house'), 'required' => '']) }}
                                </div>
                            </div>
                            <div class="form-group row">
                                {{ Form::label('present_road', __($lang.'form.present.road_label') , ['class' => 'col-form-label col-lg-4 text-right required']) }}
                                <div class="col-lg-8">
                                    {{ Form::text('present_road', Null, ['class' => 'form-control', 'placeholder' =>  __($lang.'form.present.road'), 'required' => '']) }}
                                </div>
                            </div>
                            <div class="form-group row">
                                {{ Form::label('present_village', __($lang.'form.present.village_label') , ['class' => 'col-form-label col-lg-4 text-right required']) }}
                                <div class="col-lg-8">
                                    {{ Form::text('present_village', Null, ['class' => 'form-control', 'placeholder' =>  __($lang.'form.present.village'), 'required' => '']) }}
                                </div>
                            </div>
                            <div class="form-group row">
                                {{ Form::label('present_post', __($lang.'form.present.post_label') , ['class' => 'col-form-label col-lg-4 text-right required']) }}
                                <div class="col-lg-8">
                                    {{ Form::text('present_post', Null, ['class' => 'form-control', 'placeholder' =>  __($lang.'form.present.post'), 'required' => '']) }}
                                </div>
                            </div>
                            <div class="form-group row">
                                {{ Form::label('present_upozila', __($lang.'form.present.upozila_label') , ['class' => 'col-form-label col-lg-4 text-right required']) }}
                                <div class="col-lg-8">
                                    {{ Form::text('present_upozila', Null, ['class' => 'form-control', 'placeholder' =>  __($lang.'form.present.upozila'), 'required' => '']) }}
                                </div>
                            </div>
                            <div class="form-group row">
                                {{ Form::label('present_district', __($lang.'form.present.district_label') , ['class' => 'col-form-label col-lg-4 text-right required']) }}
                                <div class="col-lg-8">
                                    {{ Form::text('present_district', Null, ['class' => 'form-control', 'placeholder' =>  __($lang.'form.present.district'), 'required' => '']) }}
                                </div>
                            </div>
                            <div class="form-group row">
                                {{ Form::label('present_postcode', __($lang.'form.present.post_code_label') , ['class' => 'col-form-label col-lg-4 text-right required']) }}
                                <div class="col-lg-8">
                                    {{ Form::text('present_postcode', Null, ['class' => 'form-control', 'placeholder' =>  __($lang.'form.present.post_code'), 'required' => '']) }}
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <h5 class="text-center">@lang($lang.'form.permanent.title') <span style="font-size: 14px; margin-left: 3px;">{{ Form::checkbox('same_as_present', 'same_as_present', Null, ['id'=> 'same_as_present'])}} @lang($lang.'form.permanent.same')</span></h3>
                            <div class="form-group row">
                                {{ Form::label('permanent_house', __($lang.'form.permanent.house_label') , ['class' => 'col-form-label col-lg-4 text-right required']) }}
                                <div class="col-lg-8">
                                    {{ Form::text('permanent_house', Null, ['class' => 'form-control', 'placeholder' =>  __($lang.'form.permanent.house'), 'required' => '']) }}
                                </div>
                            </div>
                            <div class="form-group row">
                                {{ Form::label('permanent_road', __($lang.'form.permanent.road_label') , ['class' => 'col-form-label col-lg-4 text-right required']) }}
                                <div class="col-lg-8">
                                    {{ Form::text('permanent_road', Null, ['class' => 'form-control', 'placeholder' =>  __($lang.'form.permanent.road'), 'required' => '']) }}
                                </div>
                            </div>
                            <div class="form-group row">
                                {{ Form::label('permanent_village', __($lang.'form.permanent.village_label') , ['class' => 'col-form-label col-lg-4 text-right required']) }}
                                <div class="col-lg-8">
                                    {{ Form::text('permanent_village', Null, ['class' => 'form-control', 'placeholder' =>  __($lang.'form.permanent.village'), 'required' => '']) }}
                                </div>
                            </div>
                            <div class="form-group row">
                                {{ Form::label('permanent_post', __($lang.'form.permanent.post_label') , ['class' => 'col-form-label col-lg-4 text-right required']) }}
                                <div class="col-lg-8">
                                    {{ Form::text('permanent_post', Null, ['class' => 'form-control', 'placeholder' =>  __($lang.'form.permanent.post'), 'required' => '']) }}
                                </div>
                            </div>
                            <div class="form-group row">
                                {{ Form::label('permanent_upozila', __($lang.'form.permanent.upozila_label') , ['class' => 'col-form-label col-lg-4 text-right required']) }}
                                <div class="col-lg-8">
                                    {{ Form::text('permanent_upozila', Null, ['class' => 'form-control', 'placeholder' =>  __($lang.'form.permanent.upozila'), 'required' => '']) }}
                                </div>
                            </div>
                            <div class="form-group row">
                                {{ Form::label('permanent_district', __($lang.'form.permanent.district_label') , ['class' => 'col-form-label col-lg-4 text-right required']) }}
                                <div class="col-lg-8">
                                    {{ Form::text('permanent_district', Null, ['class' => 'form-control', 'placeholder' =>  __($lang.'form.permanent.district'), 'required' => '']) }}
                                </div>
                            </div>
                            <div class="form-group row">
                                {{ Form::label('permanent_postcode', __($lang.'form.permanent.post_code_label') , ['class' => 'col-form-label col-lg-4 text-right required']) }}
                                <div class="col-lg-8">
                                    {{ Form::text('permanent_postcode', Null, ['class' => 'form-control', 'placeholder' =>  __($lang.'form.permanent.post_code'), 'required' => '']) }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group row">
                                {{ Form::label('mobile_no', __($lang.'form.mobile_no_label') , ['class' => 'col-form-label col-lg-4 text-right required']) }}
                                <div class="col-lg-8">
                                    {{ Form::text('mobile_no', Null, ['class' => 'form-control', 'placeholder' =>  __($lang.'form.mobile_no'), 'required' => '']) }}
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group row">
                                {{ Form::label('phone_no', __($lang.'form.phone_no_label') , ['class' => 'col-form-label col-lg-4 text-right']) }}
                                <div class="col-lg-8">
                                    {{ Form::text('phone_no', Null, ['class' => 'form-control', 'placeholder' =>  __($lang.'form.phone_no'),]) }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group row">
                                {{ Form::label('emergency_contact_name', __($lang.'form.emergency_contact_name_label') , ['class' => 'col-form-label col-lg-4 text-right']) }}
                                <div class="col-lg-8">
                                    {{ Form::text('emergency_contact_name', Null, ['class' => 'form-control', 'placeholder' =>  __($lang.'form.emergency_contact_name'),]) }}
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group row">
                                {{ Form::label('emergency_contact', __($lang.'form.emergency_contact_label') , ['class' => 'col-form-label col-lg-4 text-right']) }}
                                <div class="col-lg-8">
                                    {{ Form::text('emergency_contact', Null, ['class' => 'form-control', 'placeholder' =>  __($lang.'form.emergency_contact')]) }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group row">
                                {{ Form::label('user_email', __($lang.'form.user_email_label') , ['class' => 'col-form-label col-lg-4 text-right']) }}
                                <div class="col-lg-8">
                                    {{ Form::email('user_email', Null, ['class' => 'form-control', 'placeholder' =>  __($lang.'form.user_email')]) }}
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group row">
                                {{ Form::label('alternate_email', __($lang.'form.alternate_email_label') , ['class' => 'col-form-label col-lg-4 text-right']) }}
                                <div class="col-lg-8">
                                    {{ Form::email('alternate_email', Null, ['class' => 'form-control', 'placeholder' =>  __($lang.'form.alternate_email'),]) }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <span class="font-weight-semibold">{{__('trt.employee_form.section4')}}</span>
                <div style="background-color: #f5f5f5; ">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group row mb-0 pb-0">
                                {{ Form::label('exam_name', __($lang.'form.exam_name') , ['class' => 'col-form-label col-lg-1 text-center required']) }}
                                {{ Form::label('institute_name', __($lang.'form.institute_name') , ['class' => 'col-form-label col-lg-3 text-center required']) }}
                                {{ Form::label('board_or_university', __($lang.'form.board_or_university') , ['class' => 'col-form-label col-lg-3 text-center required']) }}
                                {{ Form::label('group', __($lang.'form.group') , ['class' => 'col-form-label col-lg-2 text-center required']) }}
                                {{ Form::label('result', __($lang.'form.result') , ['class' => 'col-form-label col-lg-1 text-center required']) }}
                                {{ Form::label('passing_year', __($lang.'form.passing_year') , ['class' => 'col-form-label col-lg-1 text-center required']) }}
                                {{Form::hidden('academic_row', 1, ['id' => 'academic_field_row'])}}
                                {{Form::hidden('academic_total_row', 1, ['id' => 'academic_field_total_row'])}}
                                <div class="col-lg-1">
                                    <span class="btn btn-success btn-sm" data-lang="{{$lang}}" data-url="{{route('ajax.academic_field')}}" id="add_field" data-field="academic_field">+</span>
                                </div>
                            </div>
                            <hr class="mt-0 mb-1">
                            <div id="academic_field">
                                <div class="form-group row" id="academic_row_id_1">
                                    <div class="col-lg-1">
                                        {{ Form::text('exam_name[]', Null, ['class' => 'form-control', 'placeholder' =>  __($lang.'form.exam_name'), 'required' => '', 'id' => 'exam_name_1']) }}
                                    </div>
                                    <div class="col-lg-3">
                                        {{ Form::text('institute_name[]', Null, ['class' => 'form-control', 'placeholder' =>  __($lang.'form.institute_name'), 'required' => '', 'id' => 'institute_name_1']) }}
                                    </div>
                                    <div class="col-lg-3">
                                        {{ Form::text('board_or_university[]', Null, ['class' => 'form-control', 'placeholder' =>  __($lang.'form.board_or_university'), 'required' => '', 'id' => 'board_or_university_1']) }}
                                    </div>
                                    <div class="col-lg-2">
                                        {{ Form::text('group[]', Null, ['class' => 'form-control', 'placeholder' =>  __($lang.'form.group'), 'required' => '', 'id' => 'group_1']) }}
                                    </div>
                                    <div class="col-lg-1">
                                        {{ Form::text('result[]', Null, ['class' => 'form-control', 'placeholder' =>  __($lang.'form.result'), 'required' => '', 'id' => 'result_1']) }}
                                    </div>
                                    <div class="col-lg-1">
                                        {{ Form::text('passing_year[]', Null, ['class' => 'form-control', 'placeholder' =>  __($lang.'form.passing_year'), 'required' => '', 'id' => 'passing_year_1']) }}
                                    </div>
                                    <div class="col-lg-1">
                                        <span class="btn btn-danger btn-sm" id="remove_field" data-row="academic_row" data-field="academic_field" data-id="1">X</span>
                                    </div>
                                </div>
                            </div>
                            <div id="academic_field_ajaxloader" class="row p-2"  style="border-bottom: 1px solid #ddd; display: none;">
                                <div class="col-md-12 text-center">
                                    <img src="{{asset('asset/ajaxloader.gif')}}" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <span class="font-weight-semibold">{{__('trt.employee_form.section5')}}</span>
                <div style="background-color: #f5f5f5; ">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group row mb-0 pb-0">
                                {{ Form::label('document_name', __($lang.'form.document_name_label') , ['class' => 'col-form-label col-lg-3 text-center']) }}
                                {{ Form::label('employee_document_type_id', __($lang.'form.document_type_label') , ['class' => 'col-form-label col-lg-3 text-center']) }}
                                {{ Form::label('document', __($lang.'form.document_label') , ['class' => 'col-form-label col-lg-3 text-center']) }}
                                {{ Form::label('description', __($lang.'form.description_label') , ['class' => 'col-form-label col-lg-2 text-center']) }}
                                <div class="col-lg-1">
                                    <span class="btn btn-success btn-sm" data-lang="{{$lang}}" data-url="{{route('ajax.document_field')}}" id="add_field" data-field="document_field">+</span>
                                </div>
                                {{Form::hidden('document_row', 1, ['id' => 'document_field_row'])}}
                                {{Form::hidden('document_total_row', 1, ['id' => 'document_field_total_row'])}}
                            </div>
                        </div>
                    </div>
                    <hr class="mt-0 mb-1">
                    <div id="document_field">
                        <div class="row" id="document_row_id_1">
                            <div class="col-lg-12">
                                <div class="form-group row">
                                    <div class="col-lg-3">
                                        {{ Form::text('document_name[]', Null, ['class' => 'form-control', 'placeholder' =>  __($lang.'form.document_name')]) }}
                                    </div>
                                    <div class="col-lg-3">
                                        {!! Form::select('employee_document_type_id[]', $document_types, Null, ['class' => 'form-control select', 'data-placeholder' =>  __($lang.'form.document_type'), 'data-parsley-errors-container' =>'#document_type_id_error']) !!}
                                        <span id="document_type_id_error"></span>
                                    </div>
                                    <div class="col-lg-2">
                                        {{ Form::file('document[]', ['class' => 'form-control-file', 'placeholder' =>  __($lang.'form.document')]) }}
                                    </div>
                                    <div class="col-lg-3">
                                        {{ Form::textarea('description[]', Null, ['class' => 'form-control', 'placeholder' =>  __($lang.'form.description'), 'rows' => '1', 'style' => 'max-height: 37px; min-height: 37px']) }}
                                    </div>
                                    <div class="col-lg-1">
                                        <span class="btn btn-danger btn-sm" data-id="1" data-row="document_row" data-field="document_field" id="remove_field">X</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="document_field_ajaxloader" class="row p-2"  style="border-bottom: 1px solid #ddd; display: none;">
                        <div class="col-md-12 text-center">
                            <img src="{{asset('asset/ajaxloader.gif')}}" alt="">
                        </div>
                    </div>
                </div>
                <span class="font-weight-semibold">{{__('trt.employee_form.section6')}}</span>
                <div style="background-color: #f5f5f5; ">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group row mb-0 pb-0">
                                {{ Form::label('account_name', __($lang.'form.account_name_label') , ['class' => 'col-form-label col-lg-3 text-center']) }}
                                {{ Form::label('bank_id', __($lang.'form.bank_label') , ['class' => 'col-form-label col-lg-3 text-center']) }}
                                {{ Form::label('branch_name', __($lang.'form.branch_name_label') , ['class' => 'col-form-label col-lg-3 text-center']) }}
                                {{ Form::label('account_no', __($lang.'form.account_no_label') , ['class' => 'col-form-label col-lg-2 text-center']) }}
                                <div class="col-lg-1">
                                    <span class="btn btn-success btn-sm" data-lang="{{$lang}}" data-url="{{route('ajax.account_field')}}" id="add_field" data-field="account_field">+</span>
                                </div>
                                {{Form::hidden('account_row', 1, ['id' => 'account_field_row'])}}
                                {{Form::hidden('account_total_row', 1, ['id' => 'account_field_total_row'])}}
                            </div>
                        </div>
                    </div>
                    <hr class="mt-0 mb-1">
                    <div id="account_field">
                        <div class="row" id="account_row_id_1">
                            <div class="col-lg-12">
                                <div class="form-group row">
                                    <div class="col-lg-3">
                                        {{ Form::text('account_name[]', Null, ['class' => 'form-control', 'placeholder' =>  __($lang.'form.account_name')]) }}
                                    </div>
                                    <div class="col-lg-3">
                                        {!! Form::select('bank_id[]', $banks, Null, ['class' => 'form-control select', 'data-placeholder' =>  __($lang.'form.bank'), 'data-parsley-errors-container' =>'#bank_id_error']) !!}
                                        <span id="bank_id_error"></span>
                                    </div>
                                    <div class="col-lg-3">
                                        {{ Form::text('branch_name[]', Null, ['class' => 'form-control', 'placeholder' =>  __($lang.'form.branch_name')]) }}
                                    </div>
                                    <div class="col-lg-2">
                                        {{ Form::text('account_no[]', Null, ['class' => 'form-control', 'placeholder' =>  __($lang.'form.account_no')]) }}
                                    </div>
                                    <div class="col-lg-1">
                                        <span class="btn btn-danger btn-sm" data-id="1" data-row="account_row" data-field="account_field" id="remove_field">X</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="account_field_ajaxloader" class="row p-2"  style="border-bottom: 1px solid #ddd; display: none;">
                        <div class="col-md-12 text-center">
                            <img src="{{asset('asset/ajaxloader.gif')}}" alt="">
                        </div>
                    </div>
                </div>
                <span class="font-weight-semibold">{{__('trt.employee_form.section7')}}</span>
                <div style="background-color: #f5f5f5; ">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group row">
                                <div class="col-lg-6 offset-lg-3">
                                    <span style="font-size: 14px; margin-left: 3px;">
                                        {{ Form::checkbox('login_enable', 'login_enable', Null, ['id'=> 'login_enable']) }} @lang($lang.'form.login_enable')
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="login_row" style="display: none">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group row">
                                    {{ Form::label('role', __($lang.'form.role_label') , ['class' => 'col-form-label col-lg-2 text-right required']) }}
                                    <div class="col-lg-10">
                                        {{ Form::select('role', $roles, Null, ['class' => 'form-control select', 'data-placeholder' =>  __($lang.'form.role'), 'autocomplete' => 'off']) }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group row">
                                    {{ Form::label('email', __($lang.'form.email_label') , ['class' => 'col-form-label col-lg-4 text-right required']) }}
                                    <div class="col-lg-8">
                                        {{ Form::email('email', Null, ['class' => 'form-control', 'placeholder' =>  __($lang.'form.email'), 'autocomplete' => 'off']) }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group row">
                                    {{ Form::label('username', __($lang.'form.username_label') , ['class' => 'col-form-label col-lg-4 text-right required']) }}
                                    <div class="col-lg-8">
                                        {{ Form::text('username', Null, ['class' => 'form-control', 'placeholder' =>  __($lang.'form.username'), 'autocomplete' => 'off']) }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group row">
                                    {{ Form::label('password', __($lang.'form.password_label') , ['class' => 'col-form-label col-lg-4 text-right required']) }}
                                    <div class="col-lg-8">
                                        {!! Form::password('password', ['class' => 'form-control', 'placeholder' =>  __($lang.'form.password'), 'autocomplete' => 'off']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group row">
                                    {{ Form::label('password_confirmation', __($lang.'form.password_confirmation_label') , ['class' => 'col-form-label col-lg-4 text-right required']) }}
                                    <div class="col-lg-8">
                                        {{ Form::password('password_confirmation',['class' => 'form-control', 'placeholder' =>  __($lang.'form.password_confirmation'), 'autocomplete' => 'off']) }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <span class="font-weight-semibold">{{__('trt.employee_form.section8')}}</span>
                <div style="background-color: #f5f5f5; ">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group row">
                                {{ Form::label('height', __($lang.'form.height_label') , ['class' => 'col-form-label col-lg-4 text-right']) }}
                                <div class="col-lg-8">
                                    {{ Form::text('height', Null, ['class' => 'form-control', 'placeholder' =>  __($lang.'form.height')]) }}
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group row">
                                {{ Form::label('weight', __($lang.'form.weight_label') , ['class' => 'col-form-label col-lg-4 text-right']) }}
                                <div class="col-lg-8">
                                    {{ Form::text('weight', Null, ['class' => 'form-control', 'placeholder' =>  __($lang.'form.weight')]) }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group row">
                                {{ Form::label('blood_group_id', __($lang.'form.blood_group_label') , ['class' => 'col-form-label col-lg-4 text-right']) }}
                                <div class="col-lg-8">
                                    {!! Form::select('blood_group_id', $blood_groups, Null, ['class' => 'form-control select', 'data-placeholder' =>  __($lang.'form.blood_group'), 'data-parsley-errors-container' =>'#blood_group_id_error']) !!}
                                    <span id="blood_group_id_error"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group row">
                                {{ Form::label('mark', __($lang.'form.mark_label') , ['class' => 'col-form-label col-lg-4 text-right']) }}
                                <div class="col-lg-8">
                                    {{ Form::text('mark', Null,['class' => 'form-control', 'placeholder' =>  __($lang.'form.mark')]) }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-3">
                <div class="form-group row">
                    <div class="col-lg-4 offset-lg-4">
                        {{ Form::submit(isset($model) ? __('trt.form.update'):__('trt.form.create'), ['class' => 'btn btn-primary ml-3l', 'id' => 'submit']) }}
                        <button type="button" class="btn btn-link" id="submiting" style="display: none;">Submiting <img src="{{ asset('asset/ajaxloader.gif') }}"></button>
                        <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
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