<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePhoneNumberTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('phone_number', function(Blueprint $table)
		{
			$table->integer('pid', true, true);
			$table->integer('did', false, true)->references('did')
											   ->on('docent')
											   ->onUpdate('cascade')
											   ->onDelete('cascade');

			$table->boolean('is_private');
			$table->enum('type', array('landline', 'mobile', 'fax'));
            $table->string('phone_number_private', 32);

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
		Schema::drop('phone_number');
	}

}
