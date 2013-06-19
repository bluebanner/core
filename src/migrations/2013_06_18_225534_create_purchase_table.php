<?php

use Illuminate\Database\Migrations\Migration;

class CreatePurchaseTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		
		Schema::create('core_purchase_vendor', function($table) {
			$table->engine = 'InnoDB';
			$table->increments('id');
			$table->timestamps();
			$table->softDeletes();
			
			$table->string('code', 100)->unique();
			$table->string('name', 30);
			$table->integer('category_id')->unsigned();
			$table->text('location')->nullable();
			$table->text('note')->nullable();
			$table->string('contact', 15)->nullable();
			$table->string('tel', 20)->nullable();
			$table->string('tax', 20)->nullable();
			$table->string('email', 50)->nullable();
			$table->text('contact_addr')->nullable();
			$table->text('delivery_addr')->nullable();
			$table->text('delivery_addr_ext')->nullable();
			$table->enum('payment', array('cash', 'terms'));
			$table->decimal('discount_rate', 7, 1);
			$table->smallinteger('payment_term', 7)->unsigned();
			$table->enum('status', array('normal', 'expired'));
			// $table->enum('type', array());
			$table->string('qq', 15);
		});
		
		Schema::create('core_purchase_vendor_quotation', function($table) {
			$table->engine = 'InnoDB';
			$table->increments('id');
			$table->timestamps();
			$table->softDeletes();
			
			$table->integer('vendor_id')->unsigned();
			$table->integer('item_id')->unsigned();
			$table->decimal('unit_price', 7, 2);
			$table->decimal('tax_unit_price', 7, 2);
			$table->decimal('usd_unit_price', 7, 2);
			$table->smallinteger('moq')->unsigned();
			$table->smallinteger('spq')->unsigned();
			$table->enum('price_type', array('normal', 'tax', 'usd'));
			$table->string('currency', 5);
			$table->decimal('discount', 7, 2);
			$table->decimal('tax', 7, 2);
			
			$table->foreign('vendor_id')->references('id')->on('core_purchase_vendor');
			$table->foreign('item_id')->references('id')->on('core_item_master');
		});
		
		// PR
		Schema::create('core_purchase_request', function($table) {
			$table->engine = 'InnoDB';
			$table->increments('id');
			$table->timestamps();
			$table->softDeletes();
			
			$table->integer('agent')->unsigned();
			$table->string('invoice', 30)->unique();
			$table->enum('status', array('pending', 'collection', 'frozen', 'purchasing', 'partially received', 'purchasing completely', 'partially shipment', 'completely'));
			$table->enum('type', array('order', 'shipment'));
			
			$table->foreign('agent')->references('id')->on('core_platform_user');
		});
		
		Schema::create('core_purchase_request_detail', function($table) {
			$table->engine = 'InnoDB';
			$table->increments('id');
			$table->timestamps();
			$table->softDeletes();
			
			$table->integer('warehouse_id')->unsigned();
			$table->integer('request_id')->unsigned();
			$table->integer('item_id')->unsigned();
			$table->integer('vendor_id')->unsigned();
			$table->smallinteger('qty')->unsigned();
			$table->boolean('including_tax')->default(0);
			$table->enum('transportation', array('surface', 'air', 'sea'));
			
			$table->foreign('warehouse_id')->references('id')->on('core_storage_warehouse');
			$table->foreign('request_id')->references('id')->on('core_purchase_request');
			$table->foreign('item_id')->references('id')->on('core_item_master');
			$table->foreign('vendor_id')->references('id')->on('core_purchase_vendor');
		});
		
		Schema::create('core_purchase_request_split', function($table) {
			$table->engine = 'InnoDB';
			$table->increments('id');
			$table->timestamps();
			$table->softDeletes();
			
			$table->integer('request_id')->unsigned();
			$table->integer('item_id')->unsigned();
			$table->smallinteger('qty')->unsigned();
			$table->enum('transportation', array('surface', 'air', 'sea'));
			
			$table->foreign('request_id')->references('id')->on('core_purchase_request');
			$table->foreign('item_id')->references('id')->on('core_item_master');
		});
		
		// Return
		Schema::create('core_purchase_return', function($table) {
			$table->engine = 'InnoDB';
			$table->increments('id');
			$table->timestamps();
			$table->softDeletes();
			
			$table->integer('warehouse_id')->unsigned();
			$table->integer('vendor_id')->unsigned();
			$table->integer('agent')->unsigned();
			$table->string('invoice', 30)->unique();
			$table->timestamp('return_at')->nullable();
			$table->enum('status', array('pending', 'confirmed', 'shipping', 'completely', 'cancelled'));
			$table->text('note')->nullable();
			
			$table->foreign('warehouse_id')->references('id')->on('core_storage_warehouse');
			$table->foreign('vendor_id')->references('id')->on('core_purchase_vendor');
			$table->foreign('agent')->references('id')->on('core_platform_user');
		});
		
		Schema::create('core_purchase_return_detail', function($table) {
			$table->engine = 'InnoDB';
			$table->increments('id');
			$table->timestamps();
			$table->softDeletes();
			
			$table->integer('return_id')->unsigned();
			$table->integer('item_id')->unsigned();
			$table->string('currency', 5);
			$table->smallinteger('qty')->unsigned();
			$table->text('reason')->nullable();
			$table->integer('order_id')->unsigned()->nullable();
			$table->decimal('unit_price', 7, 2);
			$table->decimal('tax_unit_price', 7, 2);
			$table->decimal('usd_unit_price', 7, 2);
			$table->decimal('exchange_rate', 7, 2);
			
			$table->foreign('return_id')->references('id')->on('core_purchase_return');
			$table->foreign('item_id')->references('id')->on('core_item_master');
		});
		
		// PO
		Schema::create('core_purchase_order', function($table) {
			$table->engine = 'InnoDB';
			$table->increments('id');
			$table->timestamps();
			$table->softDeletes();
			
			$table->integer('warehouse_id')->unsigned();
			$table->integer('agent')->unsigned();
			$table->integer('vendor_id')->unsigned();
			$table->string('invoice', 30)->unique();
			$table->enum('status', array('pending', 'confirmed', 'partially received', 'completely received', 'cancelled'));
			$table->string('currency', 5);
			$table->decimal('currency_rate', 7, 2);
			$table->decimal('tax_rate', 7, 2);
			$table->decimal('invoice_rate', 7, 4);
			$table->decimal('discount', 7, 2);
			$table->decimal('total', 7, 2);
			
			$table->string('ship_to', 50)->nullable();
			$table->string('vendor_invoice', 30)->nullable();
			$table->string('vendor_invoice_note', 30)->nullable();
			$table->text('note')->nullable();
			
			$table->smallinteger('payment_method', 4)->unsigned();
			$table->string('payment_terms', 10)->nullable();
			$table->smallinteger('payment_dates', 4)->unsigned();
			$table->timestamp('due_date')->nullable();
			$table->timestamp('delivery_date')->nullable();
			$table->integer('request_id')->unsigned()->nullable();
			
			$table->foreign('vendor_id')->references('id')->on('core_purchase_vendor');
		});
		
		Schema::create('core_purchase_order_detail', function($table) {
			$table->engine = 'InnoDB';
			$table->increments('id');
			$table->timestamps();
			$table->softDeletes();
			
			$table->integer('order_id')->unsigned();
			$table->integer('item_id')->unsigned();
			$table->string('size', 30)->nullable();
			$table->smallinteger('qty')->unsigned();
			$table->string('um', 50);
			$table->decimal('tax_unit_price', 7, 2);
			$table->decimal('usd_unit_price', 7, 2);
			$table->decimal('unit_price', 7, 2);
			$table->decimal('discount', 7, 2);
			$table->decimal('total', 7, 2);
			$table->string('specification', 255)->nullable();
			
			$table->foreign('order_id')->references('id')->on('core_purchase_order');
			$table->foreign('item_id')->references('id')->on('core_item_master');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		
		Schema::drop('core_purchase_order_detail');		
		Schema::drop('core_purchase_order');
		
		Schema::drop('core_purchase_return_detail');
		Schema::drop('core_purchase_return');
		
		Schema::drop('core_purchase_request_split');
		Schema::drop('core_purchase_request_detail');
		Schema::drop('core_purchase_request');
		
		Schema::drop('core_purchase_vendor_quotation');
		Schema::drop('core_purchase_vendor');
	}

}