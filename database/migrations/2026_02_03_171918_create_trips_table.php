<?php

use App\Enum\TripStatus;
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
        Schema::create('trips', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->foreignId('driver_id')->constrained()->cascadeOnDelete();
            $table->foreignId('vehicle_id')->constrained()->cascadeOnDelete();
            $table->timestamp('starts_at')->index();
            $table->timestamp('ends_at')->index();
            $table->string('status')->default(TripStatus::SCHEDULED->value)->index();
            $table->timestamps();

            $table->index(['company_id', 'status']);
            $table->index(['driver_id', 'starts_at', 'ends_at']);
            $table->index(['vehicle_id', 'starts_at', 'ends_at']);
            $table->index(['status', 'starts_at']);
            $table->index(['status', 'ends_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trips');
    }
};
