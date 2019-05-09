<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeQualificationsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('employee_qualifications', function (Blueprint $table) {
			$table->engine = 'InnoDB';
			$table->increments('id');
			$table->integer('employee_id')->unsigned()->nullable();
			$table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
			$table->string('exam_name')->nullable();
			$table->string('institute_name')->nullable();
			$table->string('board')->nullable();
			$table->string('group')->nullable();
			$table->string('result')->nullable();
			$table->string('passing_year')->nullable();
			$table->uuid('upload_token')->nullable();
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
		Schema::table('employee_qualifications', function (Blueprint $table) {
			$table->dropForeign('employee_qualifications_employee_id_foreign');
		});

		Schema::dropIfExists('employee_qualifications');
	}
}
