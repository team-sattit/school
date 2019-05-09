<?php

namespace App\Model\Setup\Employee;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class EmployeeCategory extends Model {
	use LogsActivity;

	protected $fillable = ['name', 'description', 'status', 'options'];
	protected $casts = ['options' => 'array'];
	protected $table = 'employee_categories';
	protected $primaryKey = 'id';
	protected static $logName = 'setup_employee_categorires';
	protected static $logFillable = true;
	protected static $logOnlyDirty = true;
	protected static $ignoreChangedAttributes = ['updated_at'];

	public function designations() {
		return $this->hasMany('App\Model\Setup\Employee\Designation');
	}
	public function getOption(string $option) {
		return array_get($this->options, $option);
	}

	public function scopeInfo() {
		return $this->with('designations');
	}

	public function scopeExcludeDefault($q) {
		return $q->where('name', '<>', config('trt.system_admin_category_name'));
	}
	public function scopeFilterById($q, $id) {
		if (!$id) {
			return $q;
		}

		return $q->where('id', '=', $id);
	}

	public function scopeFilterByName($q, $name, $s = 0) {
		if (!$name) {
			return $q;
		}

		return $s ? $q->where('name', '=', $name) : $q->where('name', 'like', '%' . $name . '%');
	}
}
