<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeDocumentsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('employee_documents', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('employee_id')->unsigned()->nullable();
			$table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
			$table->integer('employee_document_type_id')->unsigned()->nullable();
			$table->foreign('employee_document_type_id')->references('id')->on('employee_document_types')->onDelete('cascade');
			$table->string('document_name')->nullable();
			$table->text('description')->nullable();
			$table->string('document')->nullable();
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
		Schema::table('employee_documents', function (Blueprint $table) {
			$table->dropForeign('employee_documents_employee_id_foreign');
			$table->dropForeign('employee_documents_employee_document_type_id_foreign');
		});
		Schema::dropIfExists('employee_documents');
	}
}
