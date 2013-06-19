<?php

use Illuminate\Database\Migrations\Migration;

class CreateInventoryTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		
		Schema::create('core_inventory_master', function($table) {
			$table->engine = 'InnoDB';
			$table->increments('id');
			$table->timestamps();
			$table->softDeletes();
			
			$table->integer('warehouse_id')->unsigned();
			$table->integer('item_id')->unsigned();
			$table->smallInteger('qty')->unsigned();
			$table->smallInteger('hold_qty')->unsigned();
			$table->integer('account_id')->unsigned();
			$table->decimal('rmbprice', 8, 2)->nullable();
			$table->decimal('localprice', 8, 2)->nullable();
			$table->decimal('pi_price', 8, 2)->nullable();
			$table->integer('restock_id')->nullable();
			$table->boolean('status')->default(0);
			$table->timestamp('io_dt')->nullable();
			$table->integer('po_id')->nullable();
			
			// ???
			$table->enum('condition', array('normal', 'like new', 'used', 'defective'));
			
			$table->foreign('warehouse_id')->references('id')->on('core_storage_warehouse');
			$table->foreign('item_id')->references('id')->on('core_item_master');
			$table->foreign('account_id')->references('id')->on('core_platform_account');
			
			// TODO: add when IO is OK
			// $table->foreign('restock_id')->references('id')->on();
		});
		
		Schema::create('core_inventory_hold', function($table) {
			$table->engine = 'InnoDB';
			$table->increments('id');
			$table->timestamps();
			$table->softDeletes();
			
			$table->integer('inventory_id')->unsigned();
			$table->integer('relation_id')->unsigned();
			$table->integer('relation_detail_id')->unsigned();
			$table->smallInteger('qty')->unsigned();
			$table->enum('type', array('order', 'io'));
			$table->enum('status', array('pending', 'done', 'cancel'));
			
			$table->foreign('inventory_id')->references('id')->on('core_inventory_master');
		});
		
		Schema::create('core_inventory_change', function($table) {
			$table->engine = 'InnoDB';
			$table->increments('id');
			$table->timestamps();
			$table->softDeletes();
			
			$table->integer('warehouse_id')->unsigned();
			$table->integer('inventory_id')->unsigned();
			$table->integer('item_id')->unsigned();
			$table->integer('relation_id')->unsigned();
			$table->integer('agent')->unsigned();
			// TODO change to enum type
			$table->smallInteger('type')->unsigned()->nullable();
			
			$table->text('description')->nullable();
			$table->smallInteger('qty')->unsigned();
			$table->smallInteger('balance')->unsigned();
			
			$table->foreign('warehouse_id')->references('id')->on('core_storage_warehouse');
			$table->foreign('inventory_id')->references('id')->on('core_inventory_master');
			$table->foreign('item_id')->references('id')->on('core_item_master');
			$table->foreign('agent')->references('id')->on('core_platform_user');
		});
		
		Schema::create('core_inventory_allocate', function($table) {
			$table->engine = 'InnoDB';
			$table->increments('id');
			$table->timestamps();
			$table->softDeletes();
			
			$table->integer('warehouse_id')->unsigned();
			$table->integer('from_account_id')->unsigned();
			$table->integer('to_account_id')->unsigned();
			$table->integer('from_invd_id')->unsigned();
			$table->integer('to_invd_id')->unsigned();
			$table->smallInteger('qty')->unsigned();
			$table->integer('sender')->unsigned();
			$table->integer('receiver')->unsigned();
			$table->enum('status', array('completed', 'requested', 'received', 'rejected', 'cancelled'))->default('requested');
			$table->enum('type', array('channel', 'prepare', 'cron'))->default('channel');
			
			$table->foreign('warehouse_id')->references('id')->on('core_storage_warehouse');
			$table->foreign('from_account_id')->references('id')->on('core_platform_account');
			$table->foreign('to_account_id')->references('id')->on('core_platform_account');
			$table->foreign('from_invd_id')->references('id')->on('core_inventory_master');
			$table->foreign('to_invd_id')->references('id')->on('core_inventory_master');
			$table->foreign('sender')->references('id')->on('core_platform_user');
			$table->foreign('receiver')->references('id')->on('core_platform_user');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		
		Schema::drop('core_inventory_allocate');
		Schema::drop('core_inventory_change');
		Schema::drop('core_inventory_hold');		
		Schema::drop('core_inventory_master');
	}

}