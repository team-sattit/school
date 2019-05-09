@if (count($errors) > 0)
    <div class="alert alert-danger">
        <strong>@lang('trt.error_title')</strong>
        <br><br>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif