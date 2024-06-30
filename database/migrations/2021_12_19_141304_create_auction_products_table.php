<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuctionProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auction_products', function (Blueprint $table) {
            $table->id();
            $table->string('code')->nullable();
            $table->bigInteger('auction_id')->unsigned()->nullable();
            $table->bigInteger('client_id')->unsigned()->nullable();
            $table->bigInteger('product_id')->unsigned()->nullable();
            $table->bigInteger('invoice_id')->unsigned()->nullable();
            $table->enum('purchase_type', ['قطعة', 'مجموعة']);
            $table->integer('count_pieces')->nullable();
            $table->integer('price');
            $table->longText('notes')->nullable();
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
        Schema::dropIfExists('auction_products');
    }
}
