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
           CREATE OR REPLACE VIEW myfavorites AS
SELECT favorites.*, services.*, users.users_id
FROM favorites
INNER JOIN users ON users.users_id = favorites.favorites_user
INNER JOIN services ON services.services_id = favorites.favorites_services;
        ");
    }

    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS myfavorites");
    }
};
