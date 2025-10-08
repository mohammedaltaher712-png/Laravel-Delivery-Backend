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
        CREATE OR REPLACE VIEW ordersview AS
SELECT 
    summary.quantity_count,
    summary.total_price,

    carts.carts_orders,
    carts.carts_menu_details,
    carts.carts_quantitys,

    menu_details.menu_details_name,
    menu_details.menu_details_description,
    menu_details.menu_details_image,

    quantitys.quantitys_name,
    quantitys.quantitys_price,

    ordersviewaddress.orders_id,
    ordersviewaddress.orders_user,
    ordersviewaddress.orders_address,
    ordersviewaddress.orders_coupon,
    ordersviewaddress.orders_services,
    ordersviewaddress.orders_pricedelivery,
    ordersviewaddress.orders_price,
    ordersviewaddress.orders_paymentmethod,
    ordersviewaddress.orders_status,
    ordersviewaddress.orders_comments,
    ordersviewaddress.created_at,
    ordersviewaddress.updated_at,
    ordersviewaddress.addressusers_id,
    ordersviewaddress.addressusers_name,
    ordersviewaddress.addressusers_description,
    ordersviewaddress.payments_id,
    ordersviewaddress.payments_name,
    ordersviewaddress.payments_icon,
    ordersviewaddress.coupons_id,
    ordersviewaddress.coupons_name,
    ordersviewaddress.coupons_discount,
    ordersviewaddress.coupons_user,
    ordersviewaddress.coupons_belongs_service,
    ordersviewaddress.coupons_start_date,
    ordersviewaddress.coupons_end_date,
    ordersviewaddress.services_id,
    ordersviewaddress.services_name,
    ordersviewaddress.services_description,
    ordersviewaddress.services_icon,
    ordersviewaddress.services_image,
    ordersviewaddress.services_status,
    ordersviewaddress.services_belongs,
    ordersviewaddress.services_category,
        ordersviewaddress.users_name,
        ordersviewaddress.users_email,
                ordersviewaddress.users_phone,

                ordersviewaddress.addressservices_name,
                                ordersviewaddress.addressservices_description
                                



FROM (
    SELECT DISTINCT carts_orders, carts_menu_details, carts_quantitys
    FROM carts
    WHERE carts_orders != 0
) AS carts

INNER JOIN menu_details ON menu_details.menu_details_id = carts.carts_menu_details
INNER JOIN quantitys ON quantitys.quantitys_id = carts.carts_quantitys
INNER JOIN ordersviewaddress ON ordersviewaddress.orders_id = carts.carts_orders

LEFT JOIN (
    SELECT 
        carts_orders,
        carts_menu_details,
        carts_quantitys,
        COUNT(*) AS quantity_count,
        SUM(quantitys.quantitys_price) AS total_price
    FROM carts
    INNER JOIN quantitys ON quantitys.quantitys_id = carts.carts_quantitys
    WHERE carts.carts_orders != 0
    GROUP BY carts_orders, carts_menu_details, carts_quantitys
) AS summary
ON summary.carts_orders = carts.carts_orders
AND summary.carts_menu_details = carts.carts_menu_details
AND summary.carts_quantitys = carts.carts_quantitys;

    ");
    }

    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS ordersview");
    }
};
