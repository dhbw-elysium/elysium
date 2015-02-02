<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocentPhoneRelation extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('phone_number', function($table)
		{
			$table->foreign('did')->references('did')
								  ->on('docent')
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
		Schema::table('phone_number', function($table)
		{
			$table->dropForeign('phone_number_did_foreign');
		});
	}

}
