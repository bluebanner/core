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
		});
		
		Schema::create('core_platform_account', function($table) {
			$table->engine = 'InnoDB';
			
			$table->increments('id');
			$table->timestamps();
			$table->softDeletes();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('core_platform_master');
		Schema::drop('core_platform_account');
	}

}