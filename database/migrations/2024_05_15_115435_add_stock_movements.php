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
        Schema::create('stock_places', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->tinyInteger('status')->default(1);
        });

        Schema::create('stock_personals', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('surname');
            $table->string('dni');
            $table->string('phone');
            $table->tinyInteger('status')->default(1);
        });

        Schema::create('stock_movements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('place_id')->nullable()->constrained('stock_places')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('personal_id')->nullable()->constrained('stock_personals')->onUpdate('cascade')->onDelete('cascade');
            $table->tinyInteger('status')->default(1);
        });

        Schema::table('stock_histories', function (Blueprint $table) {
            $table->foreignId('movement_id')->nullable()->after('id')->constrained('stock_movements')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('place_id')->nullable()->after('movement_id')->constrained('stock_places')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('personal_id')->nullable()->after('place_id')->constrained('stock_personals')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('stock_histories', function (Blueprint $table) {
            $table->dropForeign(['movement_id']);
            $table->dropForeign(['place_id']);
            $table->dropForeign(['personal_id']);
        });

        Schema::dropIfExists('stock_movements');
        Schema::dropIfExists('stock_personals');
        Schema::dropIfExists('stock_places');
    }
};
