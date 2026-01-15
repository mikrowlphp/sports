<?php

namespace Packages\Sports\SportClub\Database\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeamsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('teams')) {
            Schema::create('teams', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('slug')->unique();
                $table->foreignId('sport_id')->constrained('sports')->cascadeOnDelete();
                $table->string('category')->nullable();
                $table->string('level')->nullable();
                $table->integer('max_members')->nullable();
                $table->boolean('is_active')->default(true);
                $table->string('logo')->nullable();
                $table->timestamps();

                // Indexes
                $table->index('sport_id');
                $table->index('is_active');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teams');
    }
}
