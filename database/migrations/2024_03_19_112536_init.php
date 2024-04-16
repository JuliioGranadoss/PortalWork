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
        Schema::create('workers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('surname');
            $table->string('dni')->unique();
            $table->string('email')->unique();
            $table->date('birth_date');
            $table->text('description')->nullable();
            $table->string('address')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('province')->nullable();
            $table->string('location')->nullable();
            $table->string('phone')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
        });

        Schema::create('degrees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('worker_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->string('name');
            $table->string('institution')->nullable();
            $table->date('start');
            $table->date('end');
            $table->float('score')->nullable();
        });

        Schema::create('experiences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('worker_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->string('name');
            $table->string('company');
            $table->date('start');
            $table->date('end');
            $table->float('score')->nullable();
        });
    
        Schema::create('others', function (Blueprint $table) {
            $table->id();
            $table->foreignId('worker_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->string('name');
            $table->text('description');
            $table->float('score')->nullable();
        });

        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('worker_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->string('name');
            $table->float('score')->nullable();
        });

        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->text('description');
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
        });

        Schema::create('worker_offers', function (Blueprint $table) {
            $table->foreignId('worker_id')->constrained()->onUpdate('cascade') ->onDelete('cascade');
            $table->foreignId('offer_id')->constrained()->onUpdate('cascade') ->onDelete('cascade');
            $table->primary(['worker_id', 'offer_id']);
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('worker_offers');
        Schema::dropIfExists('offers');
        Schema::dropIfExists('jobs');
        Schema::dropIfExists('others');
        Schema::dropIfExists('experiences');
        Schema::dropIfExists('degrees');
        Schema::dropIfExists('workers');
    }
};
