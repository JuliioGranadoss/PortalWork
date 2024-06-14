<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('workers', function (Blueprint $table) {
            $table->string('phone2')->nullable()->after('phone');
            $table->tinyInteger('driving_license_A')->default(0)->after('phone2'); 
            $table->tinyInteger('driving_license_B')->default(0)->after('driving_license_A'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('workers', function (Blueprint $table) {
            $table->dropColumn('driving_license_A');
            $table->dropColumn('driving_license_B');
            $table->dropColumn('phone2');
        });
    }
};
