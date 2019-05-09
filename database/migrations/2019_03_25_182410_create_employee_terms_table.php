<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeTermsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('employee_terms', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('employee_id')->unsigned()->nullable();
			$table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
			$table->date('joining_date')->nullable();
			$table->date('leaving_date')->nullable();
			$table->text('joining_remarks')->nullable();
			$table->text('leaving_remarks')->nullable();
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
		Schema::table('employee_terms', function (Blueprint $table) {
			$table->dropForeign('employee_terms_employee_id_foreign');
		});
		Schema::dropIfExists('employee_terms');
	}
}
