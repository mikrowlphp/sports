<?php

namespace Packages\Sports\SportClub\Database\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMatchSponsorPlacementsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('match_sponsor_placements')) {
            Schema::create('match_sponsor_placements', function (Blueprint $table) {
                $table->id();
                $table->foreignId('match_id')->constrained('matches')->cascadeOnDelete();
                $table->foreignId('sponsor_id')->constrained('sponsors')->cascadeOnDelete();
                $table->string('position')->comment('SponsorPosition enum value');
                $table->timestamps();

                // Indexes
                $table->index('match_id');
                $table->index('sponsor_id');
                $table->index('position');

                // Unique constraint: one sponsor per position per match
                $table->unique(['match_id', 'position'], 'unique_match_position');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('match_sponsor_placements');
    }
}
