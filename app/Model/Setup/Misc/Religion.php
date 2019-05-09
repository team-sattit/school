<?php

namespace App\Model\Setup\Misc;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Religion extends Model {
	use LogsActivity;

	protected $fillable = ['name', 'description', 'status', 'options'];
	protected $casts = ['options' => 'array'];
	protected $table = 'religions';
	protected $primaryKey = 'id';
	protected static $logName = 'setup_religions';
	protected static $logFillable = true;
	protected static $logOnlyDirty = true;
	protected static $ignoreChangedAttributes = ['updated_at'];
}
