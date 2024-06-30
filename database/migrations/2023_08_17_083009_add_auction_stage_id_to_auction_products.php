<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAuctionStageIdToAuctionProducts extends Migration
{
    
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('auction_products', function (Blueprint $table) {
            $table->bigInteger('auction_stage_id')
                    ->unsigned()->nullable()->after('invoice_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('auction_products', function (Blueprint $table) {
            //
        });
    }
    
}
