<?php

namespace App\Model\Setup\Student;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
class SubjectAssaign extends Model
{
    use LogsActivity;

	protected $fillable = ['class_id', 'subject_id', 'category', 'options'];
	protected $casts = ['options' => 'array'];
	protected $table = 'subject_assaigns';
	protected $primaryKey = 'id';
	protected static $logName = 'setup_subject_assaigns';
	protected static $logFillable = true;
	protected static $logOnlyDirty = true;
	protected static $ignoreChangedAttributes = ['updated_at'];

	public function subject()
	{
		return $this->belongsTo('App\Model\Setup\Student\Subject');
	}

	public function class()
	{
		return $this->belongsTo('App\Model\Setup\Student\AcademicClass');
	}
}
