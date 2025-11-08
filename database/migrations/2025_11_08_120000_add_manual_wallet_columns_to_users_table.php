<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'network_address_manual')) {
                $table->string('network_address_manual', 255)->nullable()->after('network_address');
            }
            if (!Schema::hasColumn('users', 'currency_manual')) {
                $table->string('currency_manual', 100)->nullable()->after('currency');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'network_address_manual')) {
                $table->dropColumn('network_address_manual');
            }
            if (Schema::hasColumn('users', 'currency_manual')) {
                $table->dropColumn('currency_manual');
            }
        });
    }
};
