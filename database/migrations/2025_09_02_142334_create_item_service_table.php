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
        Schema::create('item_service', function (Blueprint $table) {
           $table->id();
    $table->unsignedBigInteger('services_id');
    $table->unsignedBigInteger('items_id');

    $table->foreign('services_id')->references('services_id')->on('services')->onDelete('cascade');
    $table->foreign('items_id')->references('items_id')->on('items')->onDelete('cascade');
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_service');
    }
};
