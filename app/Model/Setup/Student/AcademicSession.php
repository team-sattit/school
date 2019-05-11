<?php

namespace App\Model\Setup\Student;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
class AcademicSession extends Model
{
    	use LogsActivity;

	protected $fillable = ['name', 'description', 'status', 'options'];
	protected $casts = ['options' => 'array'];
	protected $table = 'academic_sessions';
	protected $primaryKey = 'id';
	protected static $logName = 'setup_academic_sessions';
	protected static $logFillable = true;
	protected static $logOnlyDirty = true;
	protected static $ignoreChangedAttributes = ['updated_at'];
	protected $dates = ['start_date', 'end_date'];

}
