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
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->enum('expense_category', ['General', 'Petrol', 'Food', 'Entertainment', 'Other']);
            $table->float('amount', 10, 2);
            $table->dateTime('entrydate');
            $table->text('description')->nullable();
            $table->integer("added_by")->nullable();
            $table->tinyInteger("deleted")->default(0);
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
        Schema::dropIfExists('expenses');
    }
};
