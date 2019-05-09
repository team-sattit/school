<div class="form-group row" id="academic_row_id_{{$row}}">
    <div class="col-lg-1">
        {{ Form::text('exam_name[]', Null, ['class' => 'form-control', 'placeholder' =>  __($lang.'form.exam_name'), 'required' => '', 'id' => 'exam_name_'.$row]) }}
    </div>
    <div class="col-lg-3">
        {{ Form::text('institute_name[]', Null, ['class' => 'form-control', 'placeholder' =>  __($lang.'form.institute_name'), 'required' => '', 'id' => 'institute_name_'.$row]) }}
    </div>
    <div class="col-lg-3">
        {{ Form::text('board_or_university[]', Null, ['class' => 'form-control', 'placeholder' =>  __($lang.'form.board_or_university'), 'required' => '', 'id' => 'board_or_university_'.$row]) }}
    </div>
    <div class="col-lg-2">
        {{ Form::text('group[]', Null, ['class' => 'form-control', 'placeholder' =>  __($lang.'form.group'), 'required' => '', 'id' => 'group_'.$row]) }}
    </div>
    <div class="col-lg-1">
        {{ Form::text('result[]', Null, ['class' => 'form-control', 'placeholder' =>  __($lang.'form.result'), 'required' => '', 'id' => 'result_'.$row]) }}
    </div>
    <div class="col-lg-1">
        {{ Form::text('passing_year[]', Null, ['class' => 'form-control', 'placeholder' =>  __($lang.'form.passing_year'), 'required' => '', 'id' => 'passing_year_'.$row]) }}
    </div>
    <div class="col-lg-1">
        <span class="btn btn-danger btn-sm" data-row="academic_row" data-field="academic_field" id="remove_field" data-id="{{$row}}">X</span>
    </div>
</div>