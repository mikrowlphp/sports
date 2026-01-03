<?php

namespace Packages\Sports\SportClub\Database\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('subscriptions')) {
            Schema::create('subscriptions', function (Blueprint $table) {
                $table->id();
                $table->foreignId('customer_id')->constrained('contacts')->cascadeOnDelete();
                $table->foreignId('membership_type_id')->constrained('membership_types')->cascadeOnDelete();
                $table->date('start_date');
                $table->date('end_date')->nullable();
                $table->string('status')->default('active');
                $table->decimal('amount_paid', 10, 2);
                $table->string('payment_reference')->nullable();
                $table->text('notes')->nullable();
                $table->timestamps();

                // Indexes
                $table->index('status');
                $table->index(['customer_id', 'status']);
                $table->index(['start_date', 'end_date']);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
}
