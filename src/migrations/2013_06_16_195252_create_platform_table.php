<?php

use Illuminate\Database\Migrations\Migration;

class CreatePlatformTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('core_platform_master', function($table) {
			$table->engine = 'InnoDB';
			$table->increments('id');
			$table->timestamps();
			$table->softDeletes();
			
			$table->string('name', 100);
			$table->string('abbreviation', 10);
		});
		
		Schema::create('core_platform_account', function($table) {
			$table->engine = 'InnoDB';
			$table->increments('id');
			$table->timestamps();
			$table->softDeletes();
			
			$table->integer('platform_id')->unsigned();
			$table->string('name', 100);
			$table->string('abbreviation', 10);
			$table->string('service_email', 255)->nullable();
			$table->string('bill_email', 255)->nullable();
			$table->text('api_configuration')->nullable();
			
			$table->foreign('platform_id')->references('id')->on('core_platform_master');
		});
		
		Schema::create('core_platform_role', function($table) {
			$table->engine = 'InnoDB';
			$table->increments('id');
			$table->timestamps();
			$table->softDeletes();
			
			$table->string('name', 50);
		});
		
		Schema::create('core_platform_user', function($table) {
			$table->engine = 'InnoDB';
			$table->increments('id');
			$table->timestamps();
			$table->softDeletes();
			
			$table->string('username', 50)->unique();
			$table->string('password', 60);
			$table->string('email', 100);
			$table->integer('role_id')->unsigned();
			$table->string('firstname', 20)->nullable();
			$table->string('lastname', 20)->nullable();
			
			$table->foreign('role_id')->references('id')->on('core_platform_role');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		
		Schema::drop('core_platform_user');
		Schema::drop('core_platform_role');
		Schema::drop('core_platform_account');
		Schema::drop('core_platform_master');
		
	}

}