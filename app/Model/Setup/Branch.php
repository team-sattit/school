<?php

namespace App\Model\Setup;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Branch extends Model {
	use LogsActivity;

	protected $fillable = ['uuid', 'name', 'branch_no', 'address', 'email', 'username', 'mobile_no', 'phone_no', 'favicon', 'logo', 'status', 'description', 'options'];
	protected $casts = ['options' => 'array'];
	protected $primaryKey = 'id';
	protected $table = 'branches';
	protected static $logName = 'setup_branches';
	protected static $logFillable = true;
	protected static $logOnlyDirty = true;
	protected static $ignoreChangedAttributes = ['updated_at'];

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
