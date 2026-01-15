<?php

namespace Packages\Sports\SportClub\Database\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLessonsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('lessons')) {
            Schema::create('lessons', function (Blueprint $table) {
                $table->id();
                $table->foreignId('instructor_id')->constrained('instructors')->cascadeOnDelete();
                $table->string('title');
                $table->text('description')->nullable();
                $table->string('lesson_type');
                $table->foreignId('sport_id')->constrained('sports')->cascadeOnDelete();
                $table->datetime('scheduled_at');
                $table->integer('duration_minutes');
                $table->integer('max_participants')->default(1);
                $table->decimal('price_per_person', 10, 2);
                $table->string('location')->nullable();
                $table->string('status')->default('scheduled');
                $table->text('notes')->nullable();
                $table->timestamps();

                // Indexes
                $table->index('instructor_id');
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
        Schema::dropIfExists('lessons');
    }
}
