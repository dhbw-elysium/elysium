<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocentStatusTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('docent_status', function(Blueprint $table)
		{

			$table->integer('dsid', true, true);
			$table->unsignedInteger('did');
			$table->foreign('did')
				  ->references('did')
				  ->on('docent')
				  ->onUpdate('cascade')
				  ->onDelete('cascade');
			$table->unsignedInteger('sid');
			$table->foreign('sid')
				  ->references('sid')
				  ->on('status')
				  ->onUpdate('cascade')
				  ->onDelete('cascade');


			$table->string('comment');


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
		Schema::drop('docent_status');
	}

}
