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
        Schema::create('carts', function (Blueprint $table) {
            $table->id('carts_id');

            $table->unsignedBigInteger('carts_menu_details');
            $table->foreign('carts_menu_details')
             ->references('menu_details_id')
            ->on('menu_details')
            ->onDelete('cascade');

            $table->unsignedBigInteger('carts_quantitys');
            $table->foreign('carts_quantitys')
             ->references('quantitys_id')
            ->on('quantitys')
            ->onDelete('cascade');

            $table->unsignedBigInteger('carts_user');
            $table->foreign('carts_user')
             ->references('users_id')
            ->on('users')
            ->onDelete('cascade');
            $table->unsignedBigInteger('carts_orders')->default(0);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};
