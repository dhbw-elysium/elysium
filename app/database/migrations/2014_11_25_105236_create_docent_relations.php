<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocentRelations extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{


		Schema::table('docent', function($table)
		{
			$table->foreign('private_aid')->references('aid')
				  						  ->on('address')
										  ->onUpdate('cascade')
										  ->onDelete('cascade');
			$table->foreign('company_aid')->references('aid')
				  						  ->on('address')
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
			$table->dropForeign('docent_private_aid_foreign');
			$table->dropForeign('docent_company_aid_foreign');
		});


	}

}
