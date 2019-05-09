<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCastesTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('castes', function (Blueprint $table) {
			$table->increments('id');
			$table->string('name', 191)->nullable();
			$table->Text('description')->nullable();
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
		Schema::dropIfExists('castes');
	}
}
