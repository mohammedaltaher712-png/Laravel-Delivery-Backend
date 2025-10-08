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
        Schema::create('services', function (Blueprint $table) {
            $table->id('services_id');
            $table->string('services_name');
             $table->string('services_description');
            $table->string('services_icon');
             $table->string('services_image');
             $table->integer('services_status')->default(1);
             
              $table->unsignedBigInteger('services_belongs'); 
           $table->foreign('services_belongs')
            ->references('service_provider_id')
           ->on('service_provider')
           ->onDelete('cascade');

              $table->unsignedBigInteger('services_category'); 
           $table->foreign('services_category')
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
        Schema::dropIfExists('services');
    }
};
