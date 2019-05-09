<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeAttendanceTypesTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('employee_attendance_types', function (Blueprint $table) {
			$table->increments('id');
			$table->string('name')->nullable();
			$table->string('alias')->nullable();
			$table->string('type', 50)->nullable();
			$table->boolean('status', 1)->default(1);
			$table->text('description')->nullable();
			$table->text('options')->nullable();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('employee_attendance_types');
	}
}
