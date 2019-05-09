<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('employees', function (Blueprint $table) {
			$table->increments('id');
			$table->uuid('uuid')->nullable();
			$table->integer('branch_id')->unsigned()->nullable();
			$table->foreign('branch_id')->references('id')->on('branches')->onDelete('set null');
			$table->string('prefix', 20)->nullable();
			$table->integer('user_id')->unsigned()->nullable();
			$table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
			$table->integer('code')->default(0);
			$table->string('name')->nullable();
			$table->date('joining_date')->nullable();
			$table->date('date_of_birth')->nullable();
			$table->date('anniversary_date')->nullable();
			$table->string('gender', 20)->nullable();
			$table->string('marital_status', 20)->nullable();
			$table->string('mobile_no', 20)->nullable();
			$table->string('phone_no', 20)->nullable();
			$table->string('email', 50)->nullable();
			$table->string('alternate_email', 50)->nullable();
			$table->integer('nationality_id')->unsigned()->nullable();
			$table->foreign('nationality_id')->references('id')->on('nationalities')->onDelete('set null');
			$table->integer('blood_group_id')->unsigned()->nullable();
			$table->foreign('blood_group_id')->references('id')->on('blood_groups')->onDelete('set null');
			$table->integer('religion_id')->unsigned()->nullable();
			$table->foreign('religion_id')->references('id')->on('religions')->onDelete('set null');
			$table->integer('category_id')->unsigned()->nullable();
			$table->foreign('category_id')->references('id')->on('categories')->onDelete('set null');
			$table->integer('caste_id')->unsigned()->nullable();
			$table->foreign('caste_id')->references('id')->on('castes')->onDelete('set null');
			$table->string('photo')->nullable();
			$table->string('nid_no', 20)->nullable();
			$table->string('birth_certificate_no', 20)->nullable();
			$table->string('father_name')->nullable();
			$table->string('mother_name')->nullable();
			$table->string('spouse_name')->nullable();
			$table->string('emergency_contact_name')->nullable();
			$table->string('emergency_contact')->nullable();
			$table->string('present_house')->nullable();
			$table->string('present_road')->nullable();
			$table->string('present_village')->nullable();
			$table->string('present_post')->nullable();
			$table->string('present_upozila')->nullable();
			$table->string('present_district')->nullable();
			$table->string('present_postcode')->nullable();
			$table->boolean('same_as_present')->default(0);
			$table->string('permanent_house')->nullable();
			$table->string('permanent_road')->nullable();
			$table->string('permanent_village')->nullable();
			$table->string('permanent_post')->nullable();
			$table->string('permanent_upozila')->nullable();
			$table->string('permanent_district')->nullable();
			$table->string('permanent_postcode')->nullable();
			$table->string('height')->nullable();
			$table->string('weight')->nullable();
			$table->string('mark')->nullable();
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
		Schema::table('employees', function (Blueprint $table) {
			$table->dropForeign('employees_branch_id_foreign');
			$table->dropForeign('employees_user_id_foreign');
			$table->dropForeign('employees_nationality_id_foreign');
			$table->dropForeign('employees_blood_group_id_foreign');
			$table->dropForeign('employees_religion_id_foreign');
			$table->dropForeign('employees_category_id_foreign');
			$table->dropForeign('employees_caste_id_foreign');
		});
		Schema::dropIfExists('employees');
	}
}
