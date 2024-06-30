<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateItemsTable extends Migration {

	public function up()
	{
		Schema::create('items', function(Blueprint $table) {
			$table->id();
			$table->string('name');
			$table->integer('avg_price')->nullable();
			$table->bigInteger('created_by')->unsigned()->nullable();
			$table->bigInteger('updated_by')->unsigned()->nullable();
			$table->timestamps();
			$table->softDeletes();
		});
	}

	public function down()
	{
		Schema::drop('items');
	}
}
