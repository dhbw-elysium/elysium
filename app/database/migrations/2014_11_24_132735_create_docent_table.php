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
            $table->integer('private_aid', false, true);
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            $table->date('birth_day')->nullable();
            $table->string('birth_place')->nullable();
            $table->string('bank_bank')->nullable();
            $table->char('bank_iban', 34)->nullable();
            $table->string('lbv')->nullable();
            $table->string('company_job');
            $table->string('company_name');
            $table->integer('company_aid', false, true)->nullable();


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
