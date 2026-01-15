<?php

namespace Packages\Sports\SportClub\Database\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMatchResultsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('match_results')) {
            Schema::create('match_results', function (Blueprint $table) {
                $table->id();
                $table->foreignId('match_id')->unique()->constrained('matches')->cascadeOnDelete();
                $table->integer('home_score')->nullable();
                $table->integer('away_score')->nullable();
                $table->string('winner_type')->nullable();
                $table->foreignId('winner_team_id')->nullable()->constrained('teams')->nullOnDelete();
                $table->foreignId('winner_player_id')->nullable()->constrained('contacts')->nullOnDelete();
                $table->integer('duration_minutes')->nullable();
                $table->json('statistics')->nullable();
                $table->text('notes')->nullable();
                $table->datetime('recorded_at');
                $table->timestamps();

                // Indexes
                $table->index('winner_type');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('match_results');
    }
}
