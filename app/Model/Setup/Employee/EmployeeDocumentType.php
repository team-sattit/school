<?php

namespace App\Model\Setup\Employee;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class EmployeeDocumentType extends Model {
	use LogsActivity;

	protected $fillable = ['name', 'description', 'status', 'options'];
	protected $casts = ['options' => 'array'];
	protected $table = 'employee_document_types';
	protected $primaryKey = 'id';
	protected static $logName = 'setup_employee_document_types';
	protected static $logFillable = true;
	protected static $logOnlyDirty = true;
	protected static $ignoreChangedAttributes = ['updated_at'];

	public function employeeDocuments() {
		return $this->hasMany('App\Model\Employee\EmployeeDocument');
	}
}
