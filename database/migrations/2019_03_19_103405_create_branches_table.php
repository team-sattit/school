<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBranchesTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('branches', function (Blueprint $table) {
			$table->increments('id');
			$table->uuid('uuid')->nullable();
			$table->integer('user_id')->unsigned()->nullable();
			$table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
			$table->string('name')->nullable();
			$table->string('branch_no')->nullable();
			$table->string('address')->nullable();
			$table->string('mobile_no')->nullable();
			$table->string('phone_no')->nullable();
			$table->string('email')->nullable();
			$table->string('username')->nullable();
			$table->string('logo')->nullable();
			$table->string('favicon')->nullable();
			$table->boolean('status')->default(1);
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
		Schema::table('branches', function (Blueprint $table) {
			$table->dropForeign('branches_user_id_foreign');
		});
		Schema::dropIfExists('branches');
	}
}
