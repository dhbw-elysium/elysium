<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocentTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('docent', function(Blueprint $table)
		{
			$table->integer('did', true, true);
            $table->string('salution', 64);
            $table->string('title', 64);
            $table->string('graduation', 64);
            $table->string('first_name');
            $table->string('last_name');
            $table->integer('private_aid', false, true)->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            $table->date('birth_day')->nullable();
            $table->string('birth_place')->nullable();
            $table->string('lbv')->nullable();
            $table->string('company_job');
            $table->string('company_name');
            $table->integer('company_aid', false, true)->nullable();
            $table->string('bank_name')->nullable();
            $table->char('bank_bic', 11)->nullable();
            $table->char('bank_iban', 34)->nullable();
            $table->string('bank_blz', 24)->nullable();
            $table->string('bank_number', 36)->nullable();
			$table->integer('preferred_course_group', false, true)->nullable();
			$table->boolean('is_exdhbw');
			$table->boolean('time_mo_am');
			$table->boolean('time_mo_pm');
			$table->boolean('time_tu_am');
			$table->boolean('time_tu_pm');
			$table->boolean('time_we_am');
			$table->boolean('time_we_pm');
			$table->boolean('time_th_am');
			$table->boolean('time_th_pm');
			$table->boolean('time_fr_am');
			$table->boolean('time_fr_pm');
			$table->string('activity_teach');
			$table->string('activity_practical');
			$table->string('course_extra');
			$table->string('extra');
			$table->string('comment');

			$table->timestamps();

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('docent');
	}

}
