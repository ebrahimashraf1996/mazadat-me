<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBranchsTable extends Migration {

	public function up()
	{
		Schema::create('branchs', function(Blueprint $table) {
			$table->id();
			$table->string('name');
			$table->string('address')->nullable();
			$table->string('lat')->nullable();
			$table->string('long')->nullable();
			$table->integer('work_hours_from')->nullable();
			$table->integer('work_hours_to')->nullable();
			$table->bigInteger('created_by')->unsigned()->nullable();
			$table->bigInteger('updated_by')->unsigned()->nullable();
			$table->timestamps();
			$table->softDeletes();
		});
	}

	public function down()
	{
		Schema::drop('branchs');
	}
}
