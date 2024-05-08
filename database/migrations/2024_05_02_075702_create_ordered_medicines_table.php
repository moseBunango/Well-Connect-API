<?php

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
        Schema::create('ordered_medicines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pharmacy_order_id')
          ->constrained('pharmacy_orders', 'user_id') // Reference the column 'user_id'
          ->onDelete('cascade');
            $table->string('medicineName');
            $table->string('medicineCategory');
            $table->string('medicinePrice');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ordered_medicines');
    }
};
