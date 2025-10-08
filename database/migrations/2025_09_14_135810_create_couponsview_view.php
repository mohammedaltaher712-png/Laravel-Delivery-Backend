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
    CREATE OR REPLACE VIEW mycoupon AS
SELECT 
    coupons.coupons_id,
    coupons.coupons_name,
    coupons.coupons_discount,
    coupons.coupons_user,
    coupons.coupons_start_date,
    coupons.coupons_end_date,
    coupons.coupons_is_active,
       coupons.deleted_at,

    -- أعمدة users مع تغيير أسماء الأعمدة المتكررة إن وجدت
    users.users_id,
    users.users_name AS user_name,
    users.users_email AS user_email,
    users.users_phone AS user_phone
FROM coupons
INNER JOIN users ON users.users_id = coupons.coupons_user





        ");
    }

    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS mycoupon");
    }
};
