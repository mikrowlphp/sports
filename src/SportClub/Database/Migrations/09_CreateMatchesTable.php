<?php

namespace Packages\Sports\SportClub\Database\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMatchesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('matches')) {
            Schema::create('matches', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->foreignId('tournament_id')->nullable()->constrained('tournaments')->nullOnDelete();
                $table->foreignId('round_id')->nullable()->constrained('tournament_rounds')->nullOnDelete();
                $table->foreignId('home_team_id')->nullable()->constrained('teams')->nullOnDelete();
                $table->foreignId('away_team_id')->nullable()->constrained('teams')->nullOnDelete();
                $table->foreignId('home_player_id')->nullable()->constrained('contacts')->nullOnDelete();
                $table->foreignId('away_player_id')->nullable()->constrained('contacts')->nullOnDelete();
                $table->datetime('scheduled_at');
                $table->string('court')->nullable();
                $table->string('match_type');
                $table->string('status')->default('scheduled');
                $table->text('notes')->nullable();
                $table->timestamps();

                // Indexes
                $table->index('tournament_id');
                $table->index('status');
                $table->index(['scheduled_at', 'status']);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('matches');
    }
}
