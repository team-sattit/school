<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeDesignationsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('employee_designations', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('employee_id')->unsigned()->nullable();
			$table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
			$table->integer('designation_id')->unsigned()->nullable();
			$table->foreign('designation_id')->references('id')->on('designations')->onDelete('cascade');
			$table->integer('department_id')->unsigned()->nullable();
			$table->foreign('department_id')->references('id')->on('designations')->onDelete('cascade');
			$table->integer('employee_term_id')->unsigned()->nullable();
			$table->foreign('employee_term_id')->references('id')->on('employee_terms')->onDelete('cascade');
			$table->date('date_effective')->nullable();
			$table->date('date_end')->nullable();
			$table->text('remarks')->nullable();
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
		Schema::table('employee_designations', function (Blueprint $table) {
			$table->dropForeign('employee_designations_employee_id_foreign');
			$table->dropForeign('employee_designations_designation_id_foreign');
			$table->dropForeign('employee_designations_department_id_foreign');
			$table->dropForeign('employee_designations_employee_term_id_foreign');
		});
		Schema::dropIfExists('employee_designations');
	}
}
