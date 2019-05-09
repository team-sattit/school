<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('users', function (Blueprint $table) {
			$table->increments('id');
			$table->uuid('uuid')->nullable();
			$table->string('name')->nullable();
			$table->string('username')->nullable();
			$table->string('email')->nullable();
			$table->timestamp('email_verified_at')->nullable();
			$table->string('password');
			$table->string('activation_token', 64)->nullable();
			$table->boolean('status', 1)->default(1);
			$table->rememberToken();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('users');
	}
}
