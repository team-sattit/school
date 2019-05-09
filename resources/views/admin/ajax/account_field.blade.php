<div class="row" id="account_row_id_{{$row}}">
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
                <span class="btn btn-danger btn-sm" data-row="account_row" data-field="account_field" id="remove_field" data-id="{{$row}}">X</span>
            </div>
        </div>
    </div>
</div>