<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeAccountsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('employee_accounts', function (Blueprint $table) {
			$table->engine = 'InnoDB';
			$table->increments('id');
			$table->integer('employee_id')->unsigned()->nullable();
			$table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
			$table->string('account_name')->nullable();
			$table->string('account_number')->nullable();
			$table->integer('bank_id')->unsigned()->nullable();
			$table->foreign('bank_id')->references('id')->on('banks')->onDelete('set null');
			$table->string('branch_name')->nullable();
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
		Schema::table('employee_accounts', function (Blueprint $table) {
			$table->dropForeign('employee_accounts_employee_id_foreign');
			$table->dropForeign('employee_accounts_bank_id_foreign');
		});

		Schema::dropIfExists('employee_accounts');
	}
}
