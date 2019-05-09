<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeSalariesTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('employee_salaries', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('employee_id')->unsigned()->nullable();
			$table->foreign('employee_id', 'es_employee_id_foreign')->references('id')->on('employees')->onDelete('cascade');
			$table->float('basic_salary', 10, 2)->default(0);
			$table->float('house_rent', 10, 2)->default(0);
			$table->float('medical_allowance', 10, 2)->default(0);
			$table->float('transport_allowance', 10, 2)->default(0);
			$table->float('insurance', 10, 2)->default(0);
			$table->float('commission', 10, 2)->default(0);
			$table->float('extra', 10, 2)->default(0);
			$table->float('overtime', 10, 2)->default(0);
			$table->float('total', 10, 2)->default(0);
			$table->date('date_effective')->nullable();
			$table->date('date_end')->nullable();
			$table->text('remarks')->nullable();
			$table->boolean('status')->default(1);
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
		Schema::table('employee_salaries', function (Blueprint $table) {
			$table->dropForeign('es_employee_id_foreign');
		});
		Schema::dropIfExists('employee_salaries');
	}
}
