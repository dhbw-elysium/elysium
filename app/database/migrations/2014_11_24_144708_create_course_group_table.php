<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCourseGroupTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('course_group', function(Blueprint $table)
		{
			$table->integer('cgid', true, true);
			$table->string('title')->unique();

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
		Schema::drop('course_group');
	}

}
