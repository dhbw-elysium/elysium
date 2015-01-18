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
			$table->string('title', 128);
			$table->string('description');
			$table->string('glyph', 128)->nullable();

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

			$table->softDeletes();
			$table->unsignedInteger('deleted_by')->nullable();
			$table->foreign('deleted_by')
				  ->references('uid')
				  ->on('user')
				  ->onUpdate('cascade')
				  ->onDelete('cascade');
		});

		DB::table('status')->insert(
			array(
				'sid'			=> '1',
				'title'			=> 'Importiert',
				'description'	=> 'Der betroffene Datensatz wurde aus einer Excel-Datei importiert',
				'glyph'			=> 'glyphicon glyphicon-upload',
				'created_at'	=> new DateTime(),
				'created_by'	=> 1,
				'updated_at'	=> new DateTime(),
				'updated_by'	=> 1,
			)
		);
		DB::table('status')->insert(
			array(
				'title'			=> 'Ungeeignet',
				'description'	=> 'Der Bewerber entspricht nicht den Anforderungen',
				'glyph'			=> 'glyphicon glyphicon-thumbs-down',
				'created_at'	=> new DateTime(),
				'created_by'	=> 1,
				'updated_at'	=> new DateTime(),
				'updated_by'	=> 1,
			)
		);
		DB::table('status')->insert(
			array(
				'title'			=> 'Bewerbungsgespräch vereinbart',
				'description'	=> 'Der Bewerber wurde zum Bewerbungsgespräch eingeladen',
				'glyph'			=> 'glyphicon glyphicon-phone-alt',
				'created_at'	=> new DateTime(),
				'created_by'	=> 1,
				'updated_at'	=> new DateTime(),
				'updated_by'	=> 1,
			)
		);
		DB::table('status')->insert(
			array(
				'title'			=> 'Absage vom Dozenten',
				'description'	=> 'Der Dozent hat eine Absage mitgeteilt',
				'glyph'			=> 'glyphicon glyphicon-thumbs-down',
				'created_at'	=> new DateTime(),
				'created_by'	=> 1,
				'updated_at'	=> new DateTime(),
				'updated_by'	=> 1,
			)
		);
		DB::table('status')->insert(
			array(
				'title'			=> 'Geeignet',
				'description'	=> 'Der Bewerber entspricht den Anforderungen',
				'glyph'			=> 'glyphicon glyphicon-thumbs-up',
				'created_at'	=> new DateTime(),
				'created_by'	=> 1,
				'updated_at'	=> new DateTime(),
				'updated_by'	=> 1,
			)
		);
		DB::table('status')->insert(
			array(
				'title'			=> 'Fehlende Informationen',
				'description'	=> 'Es fehlen noch ein oder mehrere Informationen, die vom Bewerber eingereicht werden müssen',
				'glyph'			=> 'glyphicon glyphicon-warning-sign',
				'created_at'	=> new DateTime(),
				'created_by'	=> 1,
				'updated_at'	=> new DateTime(),
				'updated_by'	=> 1,
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
