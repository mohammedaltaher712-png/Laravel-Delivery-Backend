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
        Schema::create('addressservices', function (Blueprint $table) {
            $table->id('addressservices_id');
            $table->string('addressservices_name');
             $table->string('addressservices_description');
             $table->double('addressservices_latitude');
             $table->double('addressservices_longitude');

                $table->unsignedBigInteger('addressservices_service'); 
           $table->foreign('addressservices_service')
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
        Schema::dropIfExists('addressservices');
    }
};
