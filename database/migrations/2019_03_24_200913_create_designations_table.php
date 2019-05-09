<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDesignationsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('designations', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('employee_category_id')->unsigned()->nullable();
			$table->foreign('employee_category_id')->references('id')
				->on('employee_categories')->onDelete('cascade');
			$table->string('name', 191)->nullable();
			$table->boolean('is_teaching_employee')->default(0);
			$table->integer('top_designation_id')->unsigned()->nullable();
			$table->foreign('top_designation_id')->references('id')
				->on('designations')->onDelete('cascade');
			$table->text('description')->nullable();
			$table->boolean('status', 1)->default(1);
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
		Schema::table('designations', function (Blueprint $table) {
			$table->dropForeign('designations_employee_category_id_foreign');
			$table->dropForeign('designations_top_designation_id_foreign');
		});
		Schema::dropIfExists('designations');
	}
}
