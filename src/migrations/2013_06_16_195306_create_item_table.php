<?php

use Illuminate\Database\Migrations\Migration;

class CreateItemTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		
		Schema::create('core_item_category', function($table) {
			$table->engine = 'InnoDB';
			$table->increments('id');
			$table->timestamps();
			$table->softDeletes();
			
			$table->string('name', 150);
			
		});
		
		Schema::create('core_item_master', function($table) {
			$table->engine = 'InnoDB';
			$table->increments('id');
			$table->timestamps();
			$table->softDeletes();
			
			$table->string('sku', 30);
			$table->text('description');
			$table->integer('category_id')->unsigned();
			$table->decimal('length', 7, 1)->nullable();
			$table->decimal('width', 7, 1)->nullable();
			$table->decimal('height', 7, 1)->nullable();
			$table->decimal('weight', 7, 1)->nullable();
			
			$table->integer('reserve_qty')->unsigned()->nullable();
			$table->boolean('active')->default(0);
			$table->boolean('is_drop')->default(0);
			$table->boolean('is_virtual')->default(0);
			$table->boolean('is_hold_inv')->default(0);
			
			$table->enum('line_state', array('Coming', 'New Arrival', 'Regular', 'Regular-INT', 'On Promotion', 'Clearance', 'Will Deactivate', 'Inactive', 'Semis', '耗材'));
			$table->text('remark')->nullable();
			$table->smallInteger('reserve_day', 4)->default(0);
			
			$table->foreign('category_id')->references('id')->on('core_item_category');
		});
		
		Schema::create('core_item_attr', function($table) {
			$table->engine = 'InnoDB';
			$table->increments('id');
			$table->timestamps();
			$table->softDeletes();
			
			$table->integer('item_id')->unsigned();
			$table->text('specification')->nullable();
			$table->text('part_number')->nullable();
			$table->text('laptop_model')->nullable();
			$table->text('review')->nullable();
			
			$table->foreign('item_id')->references('id')->on('core_item_master');
		});
		
		Schema::create('core_item_bom', function($table) {
			$table->engine = 'InnoDB';
			$table->increments('id');
			$table->timestamps();
			$table->softDeletes();
			
			$table->integer('parent_id')->unsigned();
			$table->integer('child_id')->unsigned();
			$table->integer('agent')->unsigned();
			$table->text('note')->nullable();
			
			$table->foreign('parent_id')->references('id')->on('core_item_master');
			$table->foreign('child_id')->references('id')->on('core_item_master');
			$table->foreign('agent')->references('id')->on('core_platform_user');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
	
		Schema::drop('core_item_bom');	
		Schema::drop('core_item_attr');
		Schema::drop('core_item_master');
		Schema::drop('core_item_category');
		
	}

}