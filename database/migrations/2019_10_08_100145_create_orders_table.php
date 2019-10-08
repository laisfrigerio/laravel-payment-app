<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->text('approval_link');
            $table->decimal('value', 8, 2);
            
            $table->string('currency_id');
            $table->foreign("currency_id")->references("iso")->on("currencies");
    
            $table->unsignedBigInteger('payment_platform_id');
            $table->foreign("payment_platform_id")->references("id")->on("payment_platforms");
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
        Schema::dropIfExists('orders');
    }
}
