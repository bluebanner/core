<?php

use Illuminate\Database\Migrations\Migration;

class CreatePackagesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('core_storage_package', function($table) {
			$table->engine = 'InnoDB';
			$table->increments('id');
			$table->timestamps();
			$table->softDeletes();
			
			$table->string('barcode', 20);
			$table->enum('status', array('unknown', 'storage', 'moving', 'empty'));
			$table->integer('container_id')->unsigned()->default(0);
			
			// $table->foreign('container_id')->references('id')->on('core_storage_container');
			$table->index('barcode');
		});
		
		Schema::create('core_storage_package_items', function($table) {
			$table->engine = 'InnoDB';
			$table->increments('id');
			$table->timestamps();
			$table->softDeletes();
			
			$table->integer('package_id')->unsigned();
			$table->string('sku', 20);
			$table->smallInteger('qty')->unsigned();
			
			$table->foreign('package_id')->references('id')->on('core_storage_package');
		});
		
		Schema::create('core_storage_package_log', function($table) {
			$table->engine = 'InnoDB';
			$table->increments('id');
			$table->timestamps();
			$table->softDeletes();
			
			$table->integer('package_id')->unsigned();
			$table->integer('item_id')->unsigned();
			$table->smallInteger('qty');
			$table->smallInteger('balance');
			$table->string('agent', 20);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('core_storage_package_log');
		Schema::drop('core_storage_package_items');
		Schema::drop('core_storage_package');
	}

}