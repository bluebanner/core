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
			$table->string('api_account', 255)->nullable();
			$table->string('api_access_key', 255)->nullable();
			$table->text('api_secret_key')->nullable();
			
			$table->foreign('platform_id')->references('id')->on('core_platform_master');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		
		Schema::drop('core_platform_account');
		Schema::drop('core_platform_master');
		
	}

}