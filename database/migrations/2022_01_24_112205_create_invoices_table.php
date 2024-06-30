<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->integer('invoice_number')->nullable();
            $table->bigInteger('auction_id')->unsigned()->nullable();
            $table->bigInteger('delivery_id')->unsigned()->nullable();
            $table->bigInteger('client_id')->unsigned()->nullable();
            $table->date('delivery_date')->nullable();
            $table->integer('delivery_price')->nullable();
            $table->date('order_date')->nullable();
            $table->string('payment')->nullable();
            $table->enum('status', [1, 0])->default(0);
            $table->longText('notes')->nullable();
            $table->enum('status_invoice',['delared','canceled','delivered','delivery','no_status'])->default('no_status');
            $table->integer('total_invoice')->nullable();
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
        Schema::dropIfExists('invoices');
    }
}
