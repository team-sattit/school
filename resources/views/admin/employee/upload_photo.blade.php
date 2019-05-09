@php
$route = 'employee.';
$lang = 'employee.';
@endphp
{!! Form::model($model, ['route' => [$route.'update', $model->uuid], 'class' => 'form-validate-jquery', 'id' => 'content_form', 'method' => 'PUT', 'files' => true]) !!}
<fieldset class="mb-3">
    <legend class="text-uppercase font-size-sm font-weight-bold">{{isset($model) ? __($lang.'update') : __($lang.'create')}} <span class="text-danger">*</span> <small> @lang('trt.required') </small></legend>
    <div class="row">
        <div class="col-lg-12">
            <div class="form-group row">
                {{ Form::label('photo', __($lang.'form.photo_label') , ['class' => 'col-form-label col-lg-4 text-right required']) }}
                <div class="col-lg-8">
                    {{ Form::hidden('field', 'upload_photo') }}
                    {{ Form::file('photo', ['class' => 'form-control-file', 'placeholder' =>  __($lang.'form.photo'),'accept' => 'image/*', 'required' => '']) }}
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