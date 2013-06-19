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
		
		// IO
		Schema::create('core_storage_io_master', function($table) {
			$table->engine = 'InnoDB';
			$table->increments('id');
			$table->timestamps();
			$table->softDeletes();
			
			$table->integer('relation_id')->unsigned();
			$table->string('relation_invoice', 30);
			$table->integer('warehouse_id')->unsigned();
			$table->boolean('status')->default(0);
			$table->smallinteger('type')->default(0);
			$table->string('invoice', 30)->unique();
			$table->integer('creator')->unsigned();
			$table->integer('agent')->unsigned();
			$table->timestamp('exec');
			$table->integer('relation_out')->unsigned();
			
			$table->foreign('warehouse_id')->references('id')->on('core_storage_warehouse');
			$table->foreign('creator')->references('id')->on('core_platform_user');
			$table->foreign('agent')->references('id')->on('core_platform_user');
		});
		
		Schema::create('core_storage_io_detail', function($table) {
			$table->engine = 'InnoDB';
			$table->increments('id');
			$table->timestamps();
			$table->softDeletes();
			
			$table->integer('io_id')->unsigned();
			$table->integer('item_id')->unsigned();
			$table->smallinteger('qty')->unsigned();
			$table->smallinteger('backup_qty')->unsigned();
			$table->integer('relation_did')->unsigned();
			
			$table->foreign('io_id')->references('id')->on('core_storage_io_master');
			$table->foreign('item_id')->references('id')->on('core_item_master');
			
		});
		
		// Counting
		Schema::create('core_storage_counting_master', function($table) {
			$table->engine = 'InnoDB';
			$table->increments('id');
			$table->timestamps();
			$table->softDeletes();
			
			$table->integer('warehouse_id')->unsigned();
			$table->string('invoice', 30)->unique();
			$table->integer('agent')->unsigned();
			
			$table->foreign('warehouse_id')->references('id')->on('core_storage_warehouse');
			$table->foreign('agent')->references('id')->on('core_platform_user');
		});
		
		Schema::create('core_storage_counting_detail', function($table) {
			$table->engine = 'InnoDB';
			$table->increments('id');
			$table->timestamps();
			$table->softDeletes();
			
			$table->integer('counting_id')->unsigned();
			$table->integer('item_id')->unsigned();
			$table->smallinteger('qty')->unsigned();
			$table->smallinteger('now_qty')->unsigned();
			
			$table->foreign('counting_id')->references('id')->on('core_storage_counting_master');
			$table->foreign('item_id')->references('id')->on('core_item_master');
		});
		
		// Making
		Schema::create('core_storage_making_master', function($table) {
			$table->engine = 'InnoDB';
			$table->increments('id');
			$table->timestamps();
			$table->softDeletes();
			
			$table->integer('warehouse_id')->unsigned();
			$table->string('invoice', 30)->unique();
			$table->integer('agent')->unsigned();
			$table->text('note');
			$table->enum('status1', array('pending', 'confirm', 'stocking', 'stockout', 'completed'));
			
			$table->foreign('warehouse_id')->references('id')->on('core_storage_warehouse');
			$table->foreign('agent')->references('id')->on('core_platform_user');
		});
		
		Schema::create('core_storage_making_detail', function($table) {
			$table->engine = 'InnoDB';
			$table->increments('id');
			$table->timestamps();
			$table->softDeletes();
			
			$table->integer('making_id')->unsigned();
			$table->integer('item_id')->unsigned();
			$table->smallinteger('qty')->unsigned();
			$table->string('child_list', 255)->nullable();
			
			$table->foreign('making_id')->references('id')->on('core_storage_making_master');
			$table->foreign('item_id')->references('id')->on('core_item_master');
		});
		
		Schema::create('core_storage_making_consumable', function($table) {
			$table->engine = 'InnoDB';
			$table->increments('id');
			$table->timestamps();
			$table->softDeletes();
			
			$table->integer('making_id')->unsigned();
			$table->integer('item_id')->unsigned();
			$table->smallinteger('qty')->unsigned();
			
			$table->foreign('making_id')->references('id')->on('core_storage_making_master');
			$table->foreign('item_id')->references('id')->on('core_item_master');
		});
		
		// Other
		Schema::create('core_storage_other_master', function($table) {
			$table->engine = 'InnoDB';
			$table->increments('id');
			$table->timestamps();
			$table->softDeletes();
			
			$table->integer('warehouse_id')->unsigned();
			$table->integer('agent')->unsigned();
			$table->string('invoice', 30)->unique();
			$table->enum('status', array('pending', 'confirmed', 'done'));
			$table->text('note')->nullable();
			
			$table->foreign('warehouse_id')->references('id')->on('core_storage_warehouse');
			$table->foreign('agent')->references('id')->on('core_platform_user');
		});
		
		Schema::create('core_storage_other_detail', function($table) {
			$table->engine = 'InnoDB';
			$table->increments('id');
			$table->timestamps();
			$table->softDeletes();
			
			$table->integer('other_id')->unsigned();
			$table->integer('item_id')->unsigned();
			$table->smallinteger('qty')->unsigned();
			$table->enum('type', array('in', 'out'));
			$table->text('reason')->nullable();
			
			$table->foreign('other_id')->references('id')->on('core_storage_other_master');
			$table->foreign('item_id')->references('id')->on('core_item_master');
		});
		
		// RMA
		Schema::create('core_storage_rma_master', function($table) {
			$table->engine = 'InnoDB';
			$table->increments('id');
			$table->timestamps();
			$table->softDeletes();
			
			$table->integer('warehouse_id')->unsigned();
			$table->integer('agent')->unsigned();
			$table->string('invoice', 30)->unique();
			
			$table->foreign('warehouse_id')->references('id')->on('core_storage_warehouse');
			$table->foreign('agent')->references('id')->on('core_platform_user');
		});
		
		Schema::create('core_storage_rma_detail', function($table) {
			$table->engine = 'InnoDB';
			$table->increments('id');
			$table->timestamps();
			$table->softDeletes();
			
			$table->integer('rma_id')->unsigned();
			$table->integer('item_id')->unsigned();
			$table->smallinteger('qty')->unsigned();
			// TODO
			$table->integer('order_id')->unsigned();
			
			$table->foreign('rma_id')->references('id')->on('core_storage_rma_master');
			$table->foreign('item_id')->references('id')->on('core_item_master');
		});
		
		// Split
		Schema::create('core_storage_split_master', function($table) {
			$table->engine = 'InnoDB';
			$table->increments('id');
			$table->timestamps();
			$table->softDeletes();
			
			$table->integer('warehouse_id')->unsigned();
			$table->integer('agent')->unsigned();
			$table->string('invoice', 30)->unique();
			$table->enum('status', array('pending', 'confirmed', 'stock listing', 'stock out', 'completed'));
			$table->text('note')->nullable();
			
			$table->foreign('warehouse_id')->references('id')->on('core_storage_warehouse');
			$table->foreign('agent')->references('id')->on('core_platform_user');
		});
		
		Schema::create('core_storage_split_detail', function($table) {
			$table->engine = 'InnoDB';
			$table->increments('id');
			$table->timestamps();
			$table->softDeletes();
			
			$table->integer('split_id')->unsigned();
			$table->integer('item_id')->unsigned();
			$table->smallinteger('qty')->unsigned();
			
			$table->foreign('split_id')->references('id')->on('core_storage_split_master');
			$table->foreign('item_id')->references('id')->on('core_item_master');
		});
		
		// Shipment
		Schema::create('core_storage_shipment_master', function($table) {
			$table->engine = 'InnoDB';
			$table->increments('id');
			$table->timestamps();
			$table->softDeletes();
			
			$table->integer('warehouse_from_id')->unsigned();
			$table->integer('warehouse_to_id')->unsigned();
			$table->integer('agent')->unsigned();
			$table->string('invoice', 30)->unique();
			$table->timestamp('date_out')->nullable();
			$table->timestamp('date_eta')->nullable();
			$table->timestamp('date_receive')->nullable();
			$table->string('currency', 5);
			$table->decimal('exchange_rate', 7, 3);
			$table->enum('status', array('pending', 'submitted', 'confirmed', 'on-road', 'partially received', 'completely received', 'cancel'));
			$table->enum('transportation', array('surface', 'air', 'sea'));
			$table->string('carrier', 45)->nullable();
			$table->string('tracking', 45)->nullable();
			$table->text('note')->nullable();
			$table->decimal('shipping_fee', 7, 2)->nullable();
			
			$table->foreign('warehouse_from_id')->references('id')->on('core_storage_warehouse');
			$table->foreign('warehouse_to_id')->references('id')->on('core_storage_warehouse');
			$table->foreign('agent')->references('id')->on('core_platform_user');
		});
		
		Schema::create('core_storage_shipment_detail', function($table) {
			$table->engine = 'InnoDB';
			$table->increments('id');
			$table->timestamps();
			$table->softDeletes();
			
			$table->integer('shipment_id')->unsigned();
			$table->integer('item_id')->unsigned();
			$table->smallinteger('qty')->unsigned();
			$table->decimal('pi_price', 7, 2);
			// TODO
			$table->integer('box_id')->unsigned();
			
			$table->foreign('shipment_id')->references('id')->on('core_storage_shipment_master');
			$table->foreign('item_id')->references('id')->on('core_item_master');
		});
		
		// Location 
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
		
		Schema::drop('core_storage_shipment_detail');
		Schema::drop('core_storage_shipment_master');
		
		Schema::drop('core_storage_split_detail');
		Schema::drop('core_storage_split_master');
		
		Schema::drop('core_storage_rma_detail');
		Schema::drop('core_storage_rma_master');
		
		Schema::drop('core_storage_other_detail');
		Schema::drop('core_storage_other_master');
		
		Schema::drop('core_storage_making_consumable');
		Schema::drop('core_storage_making_detail');
		Schema::drop('core_storage_making_master');
		
		Schema::drop('core_storage_counting_detail');
		Schema::drop('core_storage_counting_master');
		
		Schema::drop('core_storage_io_detail');
		Schema::drop('core_storage_io_master');
		
		Schema::drop('core_storage_warehouse');
	}

}