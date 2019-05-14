@php
	$route = 'setup.student.subject_assaign.';
    $lang = 'setup.student.subject_assaign.';
@endphp
@if(isset($model))
{!! Form::model($model, ['route' => [$route.'update', $model->id], 'class' => 'form-validate-jquery', 'id' => 'content_form', 'method' => 'put']) !!}
@else
{!! Form::open(['route' => $route.'store', 'class' => 'form-validate-jquery', 'id' => 'content_form']) !!}
@endif
<fieldset class="mb-3">
    <legend class="text-uppercase font-size-sm font-weight-bold">{{isset($model) ? __($lang.'update') : __($lang.'create')}} <span class="text-danger">*</span> <small> @lang('trt.required') </small></legend>
    <div class="form-group row">
        {{ Form::label('class_id', __($lang.'form.class_label') , ['class' => 'col-form-label col-lg-4 text-right required']) }}
        <div class="col-lg-6">
            {{ Form::select('class_id', $class, Null, ['class' => 'form-control select', 'data-placeholder' =>  __($lang.'form.class'), 'required' => '']) }}
        </div>
    </div>
    <div class="form-group row">
        {{ Form::label('subject_id', __($lang.'form.subject_label') , ['class' => 'col-form-label col-lg-4 text-right required']) }}
        <div class="col-lg-6">
            {{ Form::select('subject_id', $subject, Null, ['class' => 'form-control select', 'data-placeholder' =>  __($lang.'form.subject'), 'required' => '']) }}
        </div>
    </div>

    <div class="form-group row">
        {{ Form::label('category', __($lang.'form.category'), ['class' => 'col-form-label col-lg-4 text-right']) }}
        <div class="col-lg-6">
            {{ Form::select('category', $category, Null, ['class' => 'form-control select', 'data-placeholder' => 'Select A Category', 'required' => '']) }}
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