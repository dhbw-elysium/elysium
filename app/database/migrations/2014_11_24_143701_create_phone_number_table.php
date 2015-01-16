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
			$table->enum('type', array('phone', 'mobile', 'fax'));
            $table->string('number', 48);

			$table->timestamps();
			$table->unsignedInteger('created_by');
			$table->foreign('created_by')
				  ->references('uid')
				  ->on('user')
				  ->onUpdate('cascade')
				  ->onDelete('cascade');
			$table->unsignedInteger('updated_by');
			$table->foreign('updated_by')
				  ->references('uid')
				  ->on('user')
				  ->onUpdate('cascade')
				  ->onDelete('cascade');
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
