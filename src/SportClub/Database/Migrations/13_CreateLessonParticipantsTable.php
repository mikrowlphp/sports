<?php

namespace Packages\Sports\SportClub\Database\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLessonParticipantsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('lesson_participants')) {
            Schema::create('lesson_participants', function (Blueprint $table) {
                $table->id();
                $table->foreignId('lesson_id')->constrained('lessons')->cascadeOnDelete();
                $table->foreignId('customer_id')->constrained('contacts')->cascadeOnDelete();
                $table->string('status')->default('registered');
                $table->string('payment_status')->default('pending');
                $table->decimal('amount_paid', 10, 2)->nullable();
                $table->text('notes')->nullable();
                $table->timestamps();

                // Indexes
                $table->index(['lesson_id', 'status']);
                $table->index(['customer_id', 'payment_status']);
                $table->unique(['lesson_id', 'customer_id']);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lesson_participants');
    }
}
