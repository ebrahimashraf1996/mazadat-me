<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuctionStagesTable extends Migration
{
    
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auction_stages', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('auction_id')->unsigned()->nullable();
            $table->string('name')->nullable();
            $table->dateTime('start_time');
            $table->dateTime('end_time')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('auction_stages');
    }
    
}
