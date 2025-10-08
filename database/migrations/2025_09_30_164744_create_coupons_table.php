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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id('coupons_id');
            $table->string('coupons_name');
            $table->integer('coupons_discount');

            $table->unsignedBigInteger('coupons_user');
            $table->foreign('coupons_user')
             ->references('users_id')
            ->on('users')
            ->onDelete('cascade');
            $table->string('coupons_start_date')->nullable();
            $table->string('coupons_end_date')->nullable();

            $table->integer('coupons_is_active')->default(1);

        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
