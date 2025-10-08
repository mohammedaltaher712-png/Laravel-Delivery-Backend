<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->softDeletes(); // هذا يضيف عمود deleted_at (نوعه TIMESTAMP وقابل للنول)
        });
    }

    public function down()
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropSoftDeletes(); // يحذف العمود إذا أردت التراجع
        });
    }
};
