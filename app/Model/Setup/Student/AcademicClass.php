<?php

namespace App\Model\Setup\Student;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class AcademicClass extends Model
{
       	use LogsActivity;

	protected $fillable = ['name', 'description', 'status', 'options'];
	protected $casts = ['options' => 'array'];
	protected $table = 'classes';
	protected $primaryKey = 'id';
	protected static $logName = 'setup_class';
	protected static $logFillable = true;
	protected static $logOnlyDirty = true;
	protected static $ignoreChangedAttributes = ['updated_at'];

}
