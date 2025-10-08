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
        Schema::create('orders', function (Blueprint $table) {
            $table->id('orders_id');

            $table->unsignedBigInteger('orders_user');
            $table->foreign('orders_user')

             ->references('users_id')
            ->on('users')
            ->onDelete('cascade');

            $table->unsignedBigInteger('orders_address');
            $table->foreign('orders_address')

             ->references('addressusers_id')
            ->on('addressusers')
            ->onDelete('cascade');

            $table->unsignedBigInteger('orders_address_serivce');
            $table->foreign('orders_address_serivce')

             ->references('addressservices_id')
            ->on('addressservices')
            ->onDelete('cascade');

            $table->integer('orders_coupon')->default(0);

            $table->unsignedBigInteger('orders_services');
            $table->foreign('orders_services')

             ->references('services_id')
            ->on('services')
            ->onDelete('cascade');

            $table->integer('orders_pricedelivery');
            $table->integer('orders_price');

            $table->unsignedBigInteger('orders_paymentmethod');
            $table->foreign('orders_paymentmethod')

             ->references('payments_id')
            ->on('payments')
            ->onDelete('cascade');
            $table->integer('orders_status')->default(0);
            $table->string('orders_comments')->nullable();
            $table->unsignedBigInteger('orders_mosuls')->default(0);

            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
