<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("
     CREATE OR REPLACE VIEW ordersviewaddress AS
SELECT 
   orders.*,
    addressusers.*,
   
    
    payments.payments_id,
    payments.payments_name,
    payments.payments_icon,
    
    coupons.coupons_id,
    coupons.coupons_name,
    coupons.coupons_discount,
    coupons.coupons_user,
    coupons.coupons_start_date,
    coupons.coupons_end_date,
    coupons.coupons_is_active,

    services.services_id,
    services.services_name,
    services.services_description,
    services.services_icon,
 services.services_image,
    services.services_status,
    services.services_belongs,
    services.services_category,
    users.users_id,
    users.users_name,
        users.users_email,

    users.users_phone
    
FROM orders 
LEFT JOIN addressusers ON addressusers.addressusers_id = orders.orders_address
LEFT JOIN payments ON payments.payments_id = orders.orders_paymentmethod
LEFT JOIN coupons ON coupons.coupons_id = orders.orders_coupon
LEFT JOIN services ON services.services_id = orders.orders_services
LEFT JOIN users ON users.users_id = orders.orders_user;





        ");
    }

    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS ordersviewaddress");
    }
};
