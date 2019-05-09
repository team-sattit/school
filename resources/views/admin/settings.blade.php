@extends('layouts.master', ['title' => 'Site Settings'])
@section('page_header')
<div class="page-header page-header-light">
    <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
        <div class="d-flex">
            <div class="breadcrumb">
                <a href="{{ route('admin.dashboard') }}" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Home</a>
                <a class="breadcrumb-item"> Settings</a>
            </div>
            <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
        </div>
    </div>
</div>
@stop
@section('content')
{!! Form::open(['route' => 'admin.settings', 'class' => 'form-validate-jquery ', 'id' => 'settings-form', 'method' => 'put']) !!}
<div class="card">
    <div class="card-header header-elements-inline">
        <h5 class="card-title">Settings</h5>
        <div class="header-elements">
            <div class="list-icons">
                <a class="list-icons-item" data-action="collapse"></a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <fieldset class="mb-3">
            <legend class="text-uppercase font-size-sm font-weight-bold">
                <div class="col-lg-4 float-left">
                    Settings
                </div>
            </legend>
            @if (session('success'))
            <span class="d-block text-muted alert alert-success text-center" role="alert">{{session('success')}}</span>
            @endif
            <div class="row">
                <div class="col-md-6 offset-3" >
                    <div class="form-group mb-0">
                        {{ Form::label('hospital_name', 'Hospital Name', ['class' => 'col-form-label col-lg-12']) }}
                        <div class="col-lg-12">
                            {{ Form::text('hospital_name', config('settings.hospital.name'), ['class' => 'form-control', 'placeholder' => 'Hospital Name', 'required']) }}
                        </div>
                    </div>
                </div>
                <div class="col-md-6 offset-3" >
                    <div class="form-group mb-0">
                        {{ Form::label('hospital_address', 'Address', ['class' => 'col-form-label col-lg-12']) }}
                        <div class="col-lg-12">
                            {{ Form::text('hospital_address', config('settings.hospital.address'), ['class' => 'form-control', 'placeholder' => 'Address','required']) }}
                        </div>
                    </div>
                </div>
                <div class="col-md-6 offset-3" >
                    <div class="form-group mb-0">
                        {{ Form::label('hospital_phone', 'Phone', ['class' => 'col-form-label col-lg-12']) }}
                        <div class="col-lg-12">
                            {{ Form::text('hospital_mobile', config('settings.hospital.mobile'), ['class' => 'form-control', 'placeholder' => 'Phone', 'required']) }}
                        </div>
                    </div>
                </div>
                <div class="col-md-6 offset-3">
                    <div class="form-group mb-0">
                        {{ Form::label('hospital_email', 'Hospital Email', ['class' => 'col-form-label col-lg-12']) }}
                        <div class="col-lg-12">
                            {{ Form::email('hospital_email', config('settings.hospital.email'), ['class' => 'form-control', 'placeholder' => 'Hospital Email' ]) }}
                        </div>
                    </div>
                </div>
                <div class="col-md-6 offset-3">
                    <div class="form-group mb-0">
                        {{ Form::label('tax', 'Tax (%)', ['class' => 'col-form-label col-lg-12']) }}
                        <div class="col-lg-12">
                            {{ Form::text('tax', config('settings.tax'), ['class' => 'form-control', 'placeholder' => 'Tax in (%)', 'required', 'max'=> '100']) }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-md-12">
                    <div class="form-group">
                        <div class="col-lg-2 offset-lg-5">
                            {{ Form::submit('Submit', ['class' => 'btn btn-primary ml-3l', 'id' => 'submit']) }}
                            <button type="button" class="btn btn-link" id="submiting" style="display: none;">Submiting <img src="{{ asset('asset/ajaxloader.gif') }}"></button>
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>
    </div>
</div>
{!! Form::close() !!}
<!-- /basic initialization -->
@stop

@push('admin.scripts')
<!-- Theme JS files -->

<script src="{{ asset('asset/global_assets/js/plugins/forms/selects/select2.min.js') }}"></script>

<script src="{{ asset('asset/assets/js/app.js') }}"></script>
<script src="{{ asset('asset/global_assets/js/plugins/forms/validation/validate.min.js') }}"></script>
<script src="{{ asset('asset/global_assets/js/plugins/notifications/pnotify.min.js') }}"></script>
<script src="{{ asset('asset/global_assets/js/pages/settings.js') }}"></script>


<!-- /theme JS files -->
@endpush