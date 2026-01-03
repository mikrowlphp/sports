<?php

namespace Packages\Sports\SportClub\Database\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTournamentRoundsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('tournament_rounds')) {
            Schema::create('tournament_rounds', function (Blueprint $table) {
                $table->id();
                $table->foreignId('tournament_id')->constrained('tournaments')->cascadeOnDelete();
                $table->string('name');
                $table->integer('round_number');
                $table->date('start_date')->nullable();
                $table->date('end_date')->nullable();
                $table->timestamps();

                // Indexes
                $table->index(['tournament_id', 'round_number']);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tournament_rounds');
    }
}
