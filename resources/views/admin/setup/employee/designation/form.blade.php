@php
$route = 'setup.employee.designation.';
$lang = 'setup.employee.designation.';
@endphp
@if(isset($model))
{!! Form::model($model, ['route' => [$route.'update', $model->id], 'class' => 'form-validate-jquery', 'id' => 'content_form', 'method' => 'put']) !!}
@else
{!! Form::open(['route' => $route.'store', 'class' => 'form-validate-jquery', 'id' => 'content_form']) !!}
@endif
<fieldset class="mb-3">
    <legend class="text-uppercase font-size-sm font-weight-bold">{{isset($model) ? __($lang.'update') : __($lang.'create')}} <span class="text-danger">*</span> <small> @lang('trt.required') </small></legend>
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
                {{ Form::label('employee_category_id',  __($lang.'form.category_label'), ['class' => 'col-form-label col-lg-4 text-right']) }}
                <div class="col-lg-8">
                    {{ Form::select('employee_category_id', $employee_categories, Null, ['class' => 'form-control select', 'data-placeholder' =>  __($lang.'form.category'), 'required' => '', 'data-parsley-errors-container' =>'#employee_category_id_parsley_erroe']) }}
                     <span id="employee_category_id_parsley_erroe"></span>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <div class="form-group row">
                {{ Form::label('top_designation_id', __($lang.'form.top_designation_label'), ['class' => 'col-form-label col-lg-4 text-right']) }}
                <div class="col-lg-8">
                    {{ Form::select('top_designation_id', $top_designations, Null, ['class' => 'form-control select', 'data-placeholder' => __($lang.'form.top_designation')]) }}
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="col-lg-8 offset-2">
                <div class="form-check form-check-switchery mb-0">
                    <label class="form-check-label">
                         {{ Form::checkbox('is_teaching_employee', Null, Null, ['class' => 'form-control-switchery']) }}
                        {{-- <input type="checkbox" class="form-control-switchery" data-fouc> --}}
                        @lang($lang.'form.is_teaching_employee')
                    </label>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group row">
        {{ Form::label('description', __($lang.'form.description_label') , ['class' => 'col-form-label col-lg-2 text-right']) }}
        <div class="col-lg-10">
            {{ Form::textarea('description', Null, ['class' => 'form-control', 'placeholder' =>  __($lang.'form.description'), 'rows' => '3', 'style' => 'max-height: 80px; min-height: 80px']) }}
        </div>
    </div>
    <div class="form-group row">
        {{ Form::label('status', __('trt.form.status'), ['class' => 'col-form-label col-lg-2 text-right']) }}
        <div class="col-lg-10">
            {{ Form::select('status', ['1' => __('trt.status.active'), '0' => __('trt.status.inactive')], Null, ['class' => 'form-control select', 'data-placeholder' => 'Broker'."'s".' Status', 'required' => '']) }}
        </div>
    </div>
    <div class="form-group row">
        <div class="col-lg-4 offset-lg-4">
            {{ Form::submit(isset($model) ? __('trt.form.update'):__('trt.form.create'), ['class' => 'btn btn-primary ml-3l', 'id' => 'submit']) }}
            <button type="button" class="btn btn-link" id="submiting" style="display: none;">Submiting <img src="{{ asset('asset/ajaxloader.gif') }}"></button>
            <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
        </div>
    </div>
</fieldset>
{!! Form::close() !!}