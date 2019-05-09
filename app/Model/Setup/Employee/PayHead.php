<?php

namespace App\Model\Setup\Employee;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class PayHead extends Model {
	use LogsActivity;

	protected $fillable = ['name', 'alias', 'type', 'description', 'status', 'options'];
	protected $casts = ['options' => 'array'];
	protected $table = 'pay_heads';
	protected $primaryKey = 'id';
	protected static $logName = 'setup_pay_heads';
	protected static $logFillable = true;
	protected static $logOnlyDirty = true;
	protected static $ignoreChangedAttributes = ['updated_at'];

	public function payrollTemplateDetails() {
		return $this->hasMany('App\Model\Employee\PayrollTemplateDetail', 'pay_head_id');
	}

	public function getNameWithAlias() {
		return $this->name . ' (' . $this->alias . ')';
	}

	public function getOption(string $option) {
		return array_get($this->options, $option);
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

	public function scopeFilterByAlias($q, $alias, $s = 0) {
		if (!$alias) {
			return $q;
		}

		return $s ? $q->where('alias', '=', $alias) : $q->where('alias', 'like', '%' . $alias . '%');
	}

	public function scopeFilterbyStatus($q, $status) {
		return $q->where('status', $status);
	}
}
