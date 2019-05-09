<?php

namespace App\Model\Setup\Employee;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class AttendanceType extends Model {
	use LogsActivity;

	protected $fillable = ['type', 'name', 'alias', 'unit', 'status', 'description', 'options'];
	protected $casts = ['options' => 'array'];
	protected $table = 'employee_attendance_types';
	protected $primaryKey = 'id';
	protected static $logName = 'setup_attendence_types';
	protected static $logFillable = true;
	protected static $logOnlyDirty = true;
	protected static $ignoreChangedAttributes = ['updated_at'];

	public function attendances() {
		return $this->hasMany('App\Model\Employee\Attendance', 'employee_attendance_type_id');
	}

	public function getOption(string $option) {
		return array_get($this->options, $option);
	}
}
