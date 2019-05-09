<?php

namespace App\Model\Setup\Finance;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Bank extends Model {
	use LogsActivity;

	protected $fillable = ['name', 'status', 'description', 'options'];
	protected $casts = ['options' => 'array'];
	protected $primaryKey = 'id';
	protected $table = 'banks';
	protected static $logName = 'setup_banks';
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
