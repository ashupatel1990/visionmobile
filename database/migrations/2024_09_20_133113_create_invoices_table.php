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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->integer("item_id")->nullable();
            $table->text("item_description")->nullable();
            $table->date("invoice_date")->nullable();
            $table->date("warranty_expiry_date")->nullable();
            $table->string("invoice_no")->unique();
            $table->string("customer_name")->nullable();
            $table->string("customer_no")->nullable();
            $table->float("total_amount", 10, 2)->nullable();
            $table->float("cgst_rate", 10, 2)->nullable();
            $table->float("sgst_rate", 10, 2)->nullable();
            $table->float("igst_rate", 10, 2)->nullable();
            $table->float("cgst_amount", 10, 2)->nullable();
            $table->float("sgst_amount", 10, 2)->nullable();
            $table->float("igst_amount", 10, 2)->nullable();
            $table->float("discount_rate", 10, 2)->nullable();
            $table->float("tax_amount", 10, 2)->nullable();
            $table->float("net_amount", 10, 2)->nullable();
            $table->float("discount", 10, 2)->nullable();
            $table->float("profit", 10, 2)->nullable();
            $table->text("declaration")->nullable();
            $table->tinyInteger("deleted")->default(0);
            $table->tinyInteger("is_paid")->default(0);
            $table->integer("invoice_by")->nullable();
            $table->integer("quantity")->default(0);
            $table->text("customer_address")->nullable();
            $table->string('payment_type')->nullable();
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
};
