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
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->enum('device_type', ['Phone', 'Tablet', 'Laptop', 'Accessories'])->nullable();
            $table->string('model')->nullable();
            $table->string('brand')->nullable();
            $table->string('imei');
            $table->date('purchase_date')->nullable();
            $table->string('color')->nullable();
            // $table->string('serial')->nullable();
            $table->string('storage')->nullable();
            $table->date('warrentydate')->nullable();
            $table->enum('os', ['Android', 'iOS', 'Windows'])->nullable();
            $table->string('purchase_from')->nullable(); //name
            $table->string('contactno', 12)->nullable();
            $table->float('purchase_cost', 10, 2)->nullable()->default(0);
            $table->float('repairing_charge', 10, 2)->nullable()->default(0);
            $table->float('purchase_price', 10, 2)->nullable()->default(0);
            $table->date('sell_date')->nullable(); 
            $table->text('remark')->nullable();
            $table->string('condition')->optional()->nullable();
            $table->string('device_photo')->nullable();
            $table->text('document')->nullable(); //max-4/5
            $table->integer('user_id');
            $table->boolean('is_sold')->default(0);
            $table->boolean('deleted')->default(0);
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
        Schema::dropIfExists('purchases');
    }
};
