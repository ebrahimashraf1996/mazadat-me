<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProvidersTable extends Migration {

	public function up()
	{
		Schema::create('providers', function(Blueprint $table) {
			$table->id();
			$table->string('name');
			$table->string('email')->nullable();
			$table->string('phone1')->nullable();
			$table->string('phone2')->nullable();
			$table->bigInteger('created_by')->unsigned()->nullable();
			$table->bigInteger('updated_by')->unsigned()->nullable();
			$table->timestamps();
			$table->softDeletes();
		});
	}

	public function down()
	{
		Schema::drop('providers');
	}
}
