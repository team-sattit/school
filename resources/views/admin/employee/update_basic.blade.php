@php
$route = 'employee.';
$lang = 'employee.';
@endphp
{!! Form::model($model, ['route' => [$route.'update', $model->uuid], 'class' => 'form-validate-jquery', 'id' => 'content_form', 'method' => 'PUT', 'files' => true]) !!}
<fieldset class="mb-3">
    <legend class="text-uppercase font-size-sm font-weight-bold bg-primary text-center">{{__('trt.employee_form.section2') }} <span class="text-danger">*</span> <small> @lang('trt.required') </small></legend>
    <div class="row">
        <div class="col-lg-6">
            <div class="form-group row">
                {{ Form::label('name', __($lang.'form.name_label') , ['class' => 'col-form-label col-lg-4 text-right required']) }}
                <div class="col-lg-8">
                    {{ Form::hidden('field', 'basic_info') }}
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
                    {{ Form::text('date_of_birth', $model->date_of_birth->format('Y-m-d'), ['class' => 'form-control date', 'placeholder' =>  __($lang.'form.date_of_birth'), 'data-parsley-type' => 'date', 'required' => '']) }}
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
    <legend class="text-uppercase font-size-sm font-weight-bold bg-primary text-center">{{__('trt.employee_form.section3') }} </legend>
    <div class="row">
        <div class="col-lg-6">
            <h5 class="text-center">@lang($lang.'form.present.title')</h5>
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
                    {{ Form::text('permanent_house', $model->same_as_present ? $model->present_house : Null, ['class' => 'form-control', 'placeholder' =>  __($lang.'form.permanent.house'), $model->same_as_present ? 'readonly' :  "required"]) }}
                </div>
            </div>
            <div class="form-group row">
                {{ Form::label('permanent_road', __($lang.'form.permanent.road_label') , ['class' => 'col-form-label col-lg-4 text-right required']) }}
                <div class="col-lg-8">
                    {{ Form::text('permanent_road',  $model->same_as_present ? $model->present_road : Null, ['class' => 'form-control', 'placeholder' =>  __($lang.'form.permanent.road'),$model->same_as_present ? 'readonly' :  "required"]) }}
                </div>
            </div>
            <div class="form-group row">
                {{ Form::label('permanent_village', __($lang.'form.permanent.village_label') , ['class' => 'col-form-label col-lg-4 text-right required']) }}
                <div class="col-lg-8">
                    {{ Form::text('permanent_village',  $model->same_as_present ? $model->present_village : Null, ['class' => 'form-control', 'placeholder' =>  __($lang.'form.permanent.village'), $model->same_as_present ? 'readonly' :  "required"]) }}
                </div>
            </div>
            <div class="form-group row">
                {{ Form::label('permanent_post', __($lang.'form.permanent.post_label') , ['class' => 'col-form-label col-lg-4 text-right required']) }}
                <div class="col-lg-8">
                    {{ Form::text('permanent_post',  $model->same_as_present ? $model->present_post : Null, ['class' => 'form-control', 'placeholder' =>  __($lang.'form.permanent.post'), $model->same_as_present ? 'readonly' :  "required"]) }}
                </div>
            </div>
            <div class="form-group row">
                {{ Form::label('permanent_upozila', __($lang.'form.permanent.upozila_label') , ['class' => 'col-form-label col-lg-4 text-right required']) }}
                <div class="col-lg-8">
                    {{ Form::text('permanent_upozila',  $model->same_as_present ? $model->present_upozila : Null, ['class' => 'form-control', 'placeholder' =>  __($lang.'form.permanent.upozila'), $model->same_as_present ? 'readonly' :  "required"]) }}
                </div>
            </div>
            <div class="form-group row">
                {{ Form::label('permanent_district', __($lang.'form.permanent.district_label') , ['class' => 'col-form-label col-lg-4 text-right required']) }}
                <div class="col-lg-8">
                    {{ Form::text('permanent_district',  $model->same_as_present ? $model->present_district : Null, ['class' => 'form-control', 'placeholder' =>  __($lang.'form.permanent.district'), $model->same_as_present ? 'readonly' :  "required"]) }}
                </div>
            </div>
            <div class="form-group row">
                {{ Form::label('permanent_postcode', __($lang.'form.permanent.post_code_label') , ['class' => 'col-form-label col-lg-4 text-right required']) }}
                <div class="col-lg-8">
                    {{ Form::text('permanent_postcode',  $model->same_as_present ? $model->present_postcode : Null, ['class' => 'form-control', 'placeholder' =>  __($lang.'form.permanent.post_code'), $model->same_as_present ? 'readonly' :  "required"]) }}
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
                    {{ Form::email('user_email', $model->email, ['class' => 'form-control', 'placeholder' =>  __($lang.'form.user_email')]) }}
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
    <legend class="text-uppercase font-size-sm font-weight-bold bg-primary text-center">{{__('trt.employee_form.section8') }} </legend>
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