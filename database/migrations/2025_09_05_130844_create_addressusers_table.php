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
        Schema::create('addressusers', function (Blueprint $table) {
            $table->id('addressusers_id');
            $table->string('addressusers_name');
             $table->string('addressusers_description');
             $table->double('addressusers_latitude');
             $table->double('addressusers_longitude');

              $table->unsignedBigInteger('addressusers_users'); 
           $table->foreign('addressusers_users')
            ->references('users_id')
           ->on('users')
           ->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addressusers');
    }
};
