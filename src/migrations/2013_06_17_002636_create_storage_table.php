<?php

use Illuminate\Database\Migrations\Migration;

class CreateStorageTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		
		Schema::create('core_storage_warehouse', function($table) {
			$table->engine = 'InnoDB';
			$table->increments('id');
			$table->timestamps();
			$table->softDeletes();
			
			$table->string('name', 20);
			$table->boolean('status')->default(0);
			$table->string('address', 255);
			$table->string('telephone', 20);
			$table->string('contact', 20);
			$table->string('country', 20);
		});
		
		
		Schema::create('core_storage_definition', function($table) {
			$table->engine = 'InnoDB';
			$table->increments('id');
			$table->timestamps();
			$table->softDeletes();
			
			$table->enum('type', array('warehouse', 'zone', 'shelf'));
			$table->string('code', 2);
			$table->integer('parent')->default(0)->unsigned();
			$table->text('desc')->nullable();
		});
		
		Schema::create('core_storage_container', function($table) {
			$table->engine = 'InnoDB';
			$table->increments('id');
			$table->timestamps();
			$table->softDeletes();
			
			$table->integer('warehouse_id')->unsigned();
			$table->integer('zone_id')->unsigned();
			$table->integer('shelf_id')->unsigned();
			$table->string('barcode', 6);
			$table->string('package', 20)->nullable();
			
			$table->foreign('warehouse_id')->references('id')->on('core_storage_definition');
			$table->foreign('zone_id')->references('id')->on('core_storage_definition');
			$table->foreign('shelf_id')->references('id')->on('core_storage_definition');
			$table->index('barcode');
			$table->index('package');
		});
		
		Schema::create('core_storage_container_log', function($table) {
			$table->engine = 'InnoDB';
			$table->increments('id');
			$table->timestamps();
			$table->softDeletes();
			
			$table->integer('container_id')->unsigned();
			$table->string('package', 20);
			$table->string('action');
	});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('core_storage_container_log');
		Schema::drop('core_storage_container');
		Schema::drop('core_storage_definition');
		Schema::drop('core_storage_warehouse');
	}

}