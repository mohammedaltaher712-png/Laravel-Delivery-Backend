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
        Schema::create('favorites', function (Blueprint $table) {
            $table->id('favorites_id');
            $table->unsignedBigInteger('favorites_user');
            $table->foreign('favorites_user')
             ->references('users_id')
            ->on('users')
            ->onDelete('cascade');

            $table->unsignedBigInteger('favorites_services');
            $table->foreign('favorites_services')
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
        Schema::dropIfExists('favorites');
    }
};
