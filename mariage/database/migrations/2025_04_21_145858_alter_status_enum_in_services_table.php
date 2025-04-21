<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('services', function (Blueprint $table) { DB::statement("ALTER TABLE services DROP CONSTRAINT services_status_check");
            DB::statement("ALTER TABLE services ADD CONSTRAINT services_status_check CHECK (status IN ('pending', 'approved', 'rejected', 'archived'))");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            DB::statement("ALTER TABLE services DROP CONSTRAINT services_status_check");
            DB::statement("ALTER TABLE services ADD CONSTRAINT services_status_check CHECK (status IN ('pending', 'approved', 'archived'))");
        });
    }
};
