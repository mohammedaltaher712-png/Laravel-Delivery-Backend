<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class () extends Migration {
    public function up(): void
    {
        DB::statement("
            CREATE OR REPLACE VIEW cardview AS
            SELECT  
                carts.carts_quantitys,
                                carts.carts_user,
                                carts.carts_orders,

                COUNT(carts.carts_id) AS quantity_count,
                SUM(quantitys.quantitys_price) AS total_price,
                quantitys.quantitys_name AS quantity_name,
                                                quantitys.quantitys_id,

                quantitys.quantitys_price AS unit_price,
                users.users_id,
                users.users_name,
                users.users_email,
                users.users_phone,
                menu_details.menu_details_id,
                menu_details.menu_details_name,
                                                menu_details.menu_details_image,

                menu_details.menu_details_description,
                                menu_details.menu_details_services

            FROM carts
            INNER JOIN menu_details ON menu_details.menu_details_id = carts.carts_menu_details
            INNER JOIN users ON users.users_id = carts.carts_user
            LEFT JOIN quantitys ON quantitys.quantitys_id = carts.carts_quantitys
            WHERE carts.carts_orders = 0
            GROUP BY 
                carts.carts_quantitys,
                                                carts.carts_user,
                                carts.carts_orders,

                                quantitys.quantitys_id,

                quantitys.quantitys_name,
                quantitys.quantitys_price,
                users.users_id,
                users.users_name,
                users.users_email,
                users.users_phone,
                menu_details.menu_details_id,
                menu_details.menu_details_name,
                                menu_details.menu_details_image,
                                menu_details.menu_details_services,

                menu_details.menu_details_description;
        ");
    }

    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS cardview");
    }
};
