<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStatusTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('status', function(Blueprint $table)
		{
			$table->increments('sid');
			$table->string('title');
			$table->string('glyph')->nullable();

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

		DB::table('status')->insert(
			array(
				'sid'	=> '1',
				'title'	=> 'Importiert',
				'glyph'	=> 'glyphicon glyphicon-import',
				'created_by'	=> 1,
				'updated_by'	=> 1
			)
    	);
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('status');
	}

}
