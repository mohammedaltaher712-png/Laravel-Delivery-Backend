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
        Schema::create('service_provider', function (Blueprint $table) {
         $table->id('service_provider_id');
            $table->string('service_provider_name');
            $table->string('service_provider_email')->unique();
            $table->string('service_provider_phone')->unique();
            $table->string('service_provider_password');
            $table->rememberToken();
        });   
      
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_provider');
    }
};
