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
        Schema::create('banner_categorys', function (Blueprint $table) {
            $table->id('banner_categorys_id');
             $table->string('banner_categorys_image');
           $table->unsignedBigInteger('banner_categorys_category'); // نوع العمود يجب أن يطابق نوع category_id
           $table->foreign('banner_categorys_category')
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
        Schema::dropIfExists('banner_categorys');
    }
};
