@extends('layouts.master')

@section('content')
<div class="d-flex justify-content-center align-items-center">
    {!! Form::open(['route' => 'login', 'class' => 'form-validate-jquery', 'id' => 'login-form']) !!}
        <div class="card mb-0">
            <div class="card-body">
                <div class="text-center mb-3">
                    <i class="icon-reading icon-2x text-slate-300 border-slate-300 border-3 rounded-round p-3 mb-3 mt-1"></i>
                    <h5 class="mb-0">{{__('auth.login_header')}}</h5>
                    <span class="d-block text-muted">{{__('auth.login_title')}}</span>
                </div>
                <div class="form-group form-group-feedback form-group-feedback-left">
                    {{ Form::text('email_or_username', Null, ['class' => 'form-control', 'placeholder' => __('auth.login_email'),  'required' => '']) }}
                    <div class="form-control-feedback">
                        <i class="icon-mail5 text-muted"></i>
                    </div>
                    @if ($errors->has('email'))
                    <span class="text-danger" role="alert">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="form-group form-group-feedback form-group-feedback-left">
                    {{ Form::password('password', ['class' => 'form-control', 'placeholder' => __('auth.login_password'),  'required' => '']) }}
                    <div class="form-control-feedback">
                        <i class="icon-lock2 text-muted"></i>
                    </div>
                    @if ($errors->has('password'))
                    <span class="text-danger" role="alert">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="form-group d-flex align-items-center">
                    <div class="form-check mb-0">
                        <label class="form-check-label">
                            <input type="checkbox" name="remember" class="form-input-styled" {{ old('remember') ? 'checked' : '' }} data-fouc>
                            @lang('auth.login_remember')
                        </label>
                    </div>
                    <a href="{{ route('password.request') }}" class="ml-auto">@lang('auth.login_forgot')</a>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-block" id="submit">@lang('auth.login_submit')<i class="icon-circle-right2 ml-2"></i></button>
                    <button id="submiting" class="btn btn-link btn-block" style="display: none; ">@lang('auth.login_submiting') <img src="{{asset('asset/ajaxloader.gif')}}" alt=""></button>
                </div>
                <span class="form-text text-center text-muted">@lang('auth.login_footer')</span>
            </div>
        </div>
    </form>
</div>
@endsection
@push('admin.scripts')
<script src="{{ asset('js/pages/login.js') }}"></script>
@endpush