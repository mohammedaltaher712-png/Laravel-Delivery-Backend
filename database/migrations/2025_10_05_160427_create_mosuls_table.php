<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('mosuls', function (Blueprint $table) {
            $table->id('mosuls_id');
            $table->string('mosuls_name');
            $table->string('mosuls_email')->unique();
            $table->bigInteger('mosuls_phone')->unique();
            $table->string('mosuls_password');
            $table->rememberToken();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mosuls');
    }
};
