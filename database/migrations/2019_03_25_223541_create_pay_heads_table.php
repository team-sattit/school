<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePayHeadsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('pay_heads', function (Blueprint $table) {
			$table->increments('id');
			$table->string('name')->unique();
			$table->string('alias')->nullable();
			$table->boolean('status', 1)->default(1);
			$table->string('type', 20)->nullable();
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
		Schema::dropIfExists('pay_heads');
	}
}
