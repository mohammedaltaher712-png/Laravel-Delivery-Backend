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
        Schema::create('quantitys', function (Blueprint $table) {
            $table->id('quantitys_id');
             $table->string('quantitys_name');
             $table->string('quantitys_price');
               $table->unsignedBigInteger('quantitys_menu_details'); 
           $table->foreign('quantitys_menu_details')
            ->references('menu_details_id')
           ->on('menu_details')
           ->onDelete('cascade');


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quantitys');
    }
};
