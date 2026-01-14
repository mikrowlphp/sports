<?php

namespace Packages\Sports\SportClub\Database\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSponsorsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('sponsors')) {
            Schema::create('sponsors', function (Blueprint $table) {
                $table->id();
                $table->ulid('ulid')->unique();
                $table->string('name');
                $table->string('logo')->nullable()->comment('Path to sponsor logo image');
                $table->string('url')->nullable()->comment('Sponsor website URL');
                $table->boolean('active')->default(true);
                $table->timestamps();

                // Indexes
                $table->index('active');
                $table->index('name');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sponsors');
    }
}
