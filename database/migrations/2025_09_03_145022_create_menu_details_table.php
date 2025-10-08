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
        Schema::create('menu_details', function (Blueprint $table) {
            $table->id('menu_details_id');
            $table->string('menu_details_name');
            $table->string('menu_details_description');
            $table->string('menu_details_price');
            $table->string('menu_details_image');
              $table->unsignedBigInteger('menu_details_menus'); 
           $table->foreign('menu_details_menus')
            ->references('menus_id')
           ->on('menus')
           ->onDelete('cascade');

            
              $table->unsignedBigInteger('menu_details_services'); 
           $table->foreign('menu_details_services')
            ->references('services_id')
           ->on('services')
           ->onDelete('cascade');


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu_details');
    }
};
