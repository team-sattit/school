<div class="row" id="document_row_id_{{$row}}">
    <div class="col-lg-12">
        <div class="form-group row">
            <div class="col-lg-3">
                {{ Form::text('document_name[]', Null, ['class' => 'form-control', 'placeholder' =>  __($lang.'form.document_name'), 'id'=> 'document_name_'.$row,]) }}
            </div>
            <div class="col-lg-3">
                {!! Form::select('employee_document_type_id[]', $document_types, Null, ['class' => 'form-control select', 'data-placeholder' =>  __($lang.'form.document_type'), 'id'=> 'document_type_id_'.$row, 'data-parsley-errors-container' =>'#document_type_id_error_'.$row]) !!}
                <span id="document_type_id_error_{{$row}}"></span>
            </div>
            <div class="col-lg-2">
                {{ Form::file('document[]', ['class' => 'form-control-file', 'placeholder' =>  __($lang.'form.document'), 'id'=> 'document_'.$row]) }}
            </div>
            <div class="col-lg-3">
                {{ Form::textarea('description[]', Null, ['class' => 'form-control', 'placeholder' =>  __($lang.'form.description'), 'id'=> 'description_'.$row, 'rows' => '1', 'style' => 'max-height: 37px; min-height: 37px']) }}
            </div>
            <div class="col-lg-1">
                <span class="btn btn-danger btn-sm" data-id="{{$row}}" data-row="document_row" data-field="document_field" id="remove_field">X</span>
            </div>
        </div>
    </div>
</div>