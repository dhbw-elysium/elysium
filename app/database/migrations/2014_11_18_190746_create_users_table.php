<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('user', function(Blueprint $table)
		{
			$table->integer('uid', true, true);
            $table->string('firstname', 128);
            $table->string('lastname', 128);
            $table->string('email', 128);
            $table->string('password', 64);
            $table->dateTime('last_login');
            $table->string('remember_token', 100)->nullable();
            $table->string('role', 64)->default(User::ROLE_ADMIN);
            $table->string('title', 64);

			$table->timestamps();
			$table->unsignedInteger('created_by')->nullable();
			$table->foreign('created_by')
				  ->references('uid')
				  ->on('user')
				  ->onUpdate('cascade')
				  ->onDelete('cascade');
			$table->unsignedInteger('updated_by')->nullable();
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

		DB::table('user')->insert(
			array(
				'uid'			=> 1,
                'title'			=> User::TITLE_MALE,
				'firstname'		=> '',
				'lastname'		=> 'Administrator',
				'email'			=> 'admin@example.com',
				'password'		=> Hash::make('admin'),
                'last_login'	=> new DateTime,
                'role'			=> User::ROLE_ADMIN
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
		Schema::drop('user');
	}

}
