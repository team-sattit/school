<?php

namespace App\Model\Setup\Employee;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class EmployeeGroup extends Model {
	use LogsActivity;

	protected $fillable = ['name', 'description', 'status', 'options'];
	protected $casts = ['options' => 'array'];
	protected $table = 'employee_groups';
	protected $primaryKey = 'id';
	protected static $logName = 'setup_employee_group';
	protected static $logFillable = true;
	protected static $logOnlyDirty = true;
	protected static $ignoreChangedAttributes = ['updated_at'];
}
