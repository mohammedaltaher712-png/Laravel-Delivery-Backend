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
        CREATE OR REPLACE VIEW serviceswithitems AS
        SELECT 
            services.services_id,
            services.services_name,
            services.services_description,
            services.services_icon,
            services.services_image,
            services.services_status,
            services.services_category,
            services.services_belongs,
            addressservices.addressservices_id,
            addressservices.addressservices_name,
            addressservices.addressservices_description,
                        addressservices.addressservices_latitude,
                                                addressservices.addressservices_longitude,


            favorites.favorites_id,
            favorites.favorites_user,
            favorites.favorites_services,
            items.items_id,
            items.items_name,
            items.items_image,
            items.items_category,
            
            category.category_id,
            category.category_name,
            category.category_image,
            
            service_provider.service_provider_id,
            service_provider.service_provider_name,
            service_provider.service_provider_email,
            service_provider.service_provider_phone

        FROM item_service
        INNER JOIN services ON services.services_id = item_service.services_id
        INNER JOIN items ON items.items_id = item_service.items_id
        INNER JOIN category ON category.category_id = services.services_category
        INNER JOIN service_provider ON service_provider.service_provider_id = services.services_belongs
                INNER JOIN addressservices ON addressservices.addressservices_service = services.services_id
                                INNER JOIN favorites ON favorites.favorites_services = services.services_id
    ");
    }

    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS serviceswithitems");
    }

};
