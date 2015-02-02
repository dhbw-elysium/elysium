<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocentDeletedRelation extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('docent', function($table)
		{

			DB::statement('ALTER TABLE docent CHANGE deleted_by deleted_by INT(10) UNSIGNED NULL DEFAULT NULL');

			$table->foreign('deleted_by')->references('uid')
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
		Schema::table('docent', function($table)
		{
			$table->dropForeign('docent_deleted_by_foreign');
		});
	}

}
