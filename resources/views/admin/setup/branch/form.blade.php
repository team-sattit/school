@php
$route = 'setup.branch.';
$lang = 'setup.branch.';
@endphp
@if(isset($model))
{!! Form::model($model, ['route' => [$route.'update', $model->id], 'class' => 'form-validate-jquery', 'id' => 'content_form', 'method' => 'PUT', 'files' => true]) !!}
@else
{!! Form::open(['route' => $route.'store', 'class' => 'form-validate-jquery', 'id' => 'content_form', 'files' => true, 'method' => 'POST']) !!}
@endif
<fieldset class="mb-3">
    <legend class="text-uppercase font-size-sm font-weight-bold">{{isset($model) ? __($lang.'update') : __($lang.'create')}} <span class="text-danger">*</span> <small> @lang('trt.required') </small></legend>
    <div class="row">
        <div class="col-lg-6">
            <div class="form-group row">
                {{ Form::label('branch_no', __($lang.'form.branch_no_label') , ['class' => 'col-form-label col-lg-4 text-right required']) }}
                <div class="col-lg-8">
                    {{ Form::text('branch_no', Null, ['class' => 'form-control', 'placeholder' =>  __($lang.'form.branch_no'), 'required' => '']) }}
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group row">
                {{ Form::label('name', __($lang.'form.name_label') , ['class' => 'col-form-label col-lg-4 text-right required']) }}
                <div class="col-lg-8">
                    {{ Form::text('name', Null, ['class' => 'form-control', 'placeholder' =>  __($lang.'form.name'), 'required' => '']) }}
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
                    {{ Form::text('phone_no', Null, ['class' => 'form-control', 'placeholder' =>  __($lang.'form.phone_no')]) }}
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <div class="form-group row">
                {{ Form::label('email', __($lang.'form.email_label') , ['class' => 'col-form-label col-lg-4 text-right required']) }}
                <div class="col-lg-8">
                    {{ Form::email('email', Null, ['class' => 'form-control', 'placeholder' =>  __($lang.'form.email'), 'required' => '']) }}
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group row">
                {{ Form::label('username', __($lang.'form.username_label') , ['class' => 'col-form-label col-lg-4 text-right required']) }}
                <div class="col-lg-8">
                    {{ Form::text('username', Null, ['class' => 'form-control', 'placeholder' =>  __($lang.'form.username'), 'required' => '']) }}
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <div class="form-group row">
                @if (isset($model))
                    {{ Form::label('password', __($lang.'form.password_label') , ['class' => 'col-form-label col-lg-4 text-right']) }}
                @else
                {{ Form::label('password', __($lang.'form.password_label') , ['class' => 'col-form-label col-lg-4 text-right required']) }}
                @endif
                <div class="col-lg-8">
                    {{ Form::password('password', ['class' => 'form-control', 'placeholder' =>  __($lang.'form.password'), !isset($model) ? 'required' :'']) }}
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group row">
                @if (isset($model))
                    {{ Form::label('password_confirmation', __($lang.'form.password_confirmation_label') , ['class' => "col-form-label col-lg-4 text-right"]) }}
                @else
                {{ Form::label('password_confirmation', __($lang.'form.password_confirmation_label') , ['class' => "col-form-label col-lg-4 text-right required"]) }}
                @endif
                <div class="col-lg-8">
                    {{ Form::password('password_confirmation', ['class' => 'form-control', 'placeholder' =>  __($lang.'form.password_confirmation'), !isset($model) ? 'required' :'']) }}
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <div class="form-group row">
                {{ Form::label('address', __($lang.'form.address_label') , ['class' => 'col-form-label col-lg-4 text-right required']) }}
                <div class="col-lg-8">
                    {{ Form::text('address', Null, ['class' => 'form-control', 'placeholder' =>  __($lang.'form.address'), 'required' => '']) }}
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group row">
                {{ Form::label('status', __('trt.form.status'), ['class' => 'col-form-label col-lg-4 text-right required']) }}
                <div class="col-lg-8">
                    {{ Form::select('status', ['1' => __('trt.status.active'), '0' => __('trt.status.inactive')], Null, ['class' => 'form-control select', 'data-placeholder' => 'Select Status', 'required' => '']) }}
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            @if (isset($model) and $model->logo)
            <div class="form-group row">
                {{ Form::label('logo', __($lang.'form.logo_label') , ['class' => 'col-form-label col-lg-4 text-right']) }}
                <div class="col-lg-8">
                    <img src="{{asset($model->logo)}}" alt="" height="100px" width="250px">
                </div>
            </div>
            <div class="col-lg-8 offset-2">
                <div class="form-check">
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">
                            <input type="checkbox" class="form-input-styled" name="logo_action" value="remove_logo" id="delete_logo">
                            Delete
                        </label>
                    </div>
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">
                            <input type="checkbox" class="form-input-styled" name="logo_action" value="update_logo" id="update_logo">
                            Update
                        </label>
                    </div>
                </div>
            </div>
            @endif
        </div>
        <div class="col-lg-6">
            @if (isset($model) and $model->favicon)
            <div class="form-group row">
                {{ Form::label('favicon', __($lang.'form.favicon_label') , ['class' => 'col-form-label col-lg-4 text-right']) }}
                <div class="col-lg-8">
                    <img src="{{asset($model->favicon)}}" alt="" height="100px" width="250px">
                </div>
                <div class="col-lg-8 offset-2">
                <div class="form-check">
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">
                            <input type="checkbox" class="form-input-styled" name="fav_action" value="remove_fav" id="delete_fav">
                            Delete
                        </label>
                    </div>
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">
                            <input type="checkbox" class="form-input-styled" name="fav_action" value="update_fav" id="update_fav">
                            Update
                        </label>
                    </div>
                </div>
            </div>
                @endif
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <div class="form-group row" @if (isset($model) and $model->logo) style="display: none;" @endif id="upload_logo_field">
                {{ Form::label('logo', __($lang.'form.logo_label') , ['class' => 'col-form-label col-lg-4 text-right']) }}
                <div class="col-lg-8">
                    @if (isset($model) and !$model->logo)
                    {{ Form::hidden('logo_action', 'upload_logo') }}
                    @endif
                    {{ Form::file('logo', ['class' => 'form-control-file', 'placeholder' =>  __($lang.'form.logo'), 'accept' => 'image/*']) }}
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group row" @if (isset($model) and $model->favicon) style="display: none;" @endif id="upload_fav_field">
                {{ Form::label('favicon', __($lang.'form.favicon_label') , ['class' => 'col-form-label col-lg-4 text-right']) }}
                <div class="col-lg-8">
                    @if (isset($model) and !$model->favicon)
                    {{ Form::hidden('fav_action', 'upload_fav') }}
                    @endif
                    {{ Form::file('favicon', ['class' => 'form-control-file', 'placeholder' =>  __($lang.'form.favicon'), 'accept' => 'image/*']) }}
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

@push('admin.scripts')

@endpush