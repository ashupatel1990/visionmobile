<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->string('model')->nullable();
            $table->string('customername')->nullable();
            // $table->string('brand')->nullable();
            $table->string('imei')->nullable();
            $table->string('contactno', 12)->nullable();
            $table->date('saledate')->nullable();
            $table->float('saleprice', 10, 2)->nullable();
            $table->float('purchaseprice', 10, 2)->nullable();
            $table->float('profit', 10, 2)->nullable(); //sellprice - purchaseprice
            $table->enum('payment_mode', ['Cash', 'Online', 'Credit Card'])->nullable();
            $table->string('remark')->nullable();
            $table->text('document')->nullable();
            $table->boolean('deleted')->default(0);
            $table->integer('stock_id')->nullable();
            $table->string('user_id')->default(0);
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
        Schema::dropIfExists('sales');
    }
};
