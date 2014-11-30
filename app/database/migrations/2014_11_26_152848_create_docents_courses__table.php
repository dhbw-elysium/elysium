<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocentsCoursesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('docent_course', function(Blueprint $table)
		{
			$table->unsignedInteger('did');
			$table->foreign('did')
				  ->references('did')
				  ->on('docent')
				  ->onUpdate('cascade')
				  ->onDelete('cascade');
			$table->unsignedInteger('cid');
			$table->foreign('cid')
				  ->references('cid')
				  ->on('course')
				  ->onUpdate('cascade')
				  ->onDelete('cascade');

			$table->primary(array('did', 'cid'));
		});

	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('docent_course');
	}

}
