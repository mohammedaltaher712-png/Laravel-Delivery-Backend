<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id('items_id');
            $table->string('items_name');
            $table->string('items_image');
           $table->unsignedBigInteger('items_category'); // نوع العمود يجب أن يطابق نوع category_id
           $table->foreign('items_category')
            ->references('category_id')
           ->on('category')
           ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
