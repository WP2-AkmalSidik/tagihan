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
        Schema::create('pelanggans', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_meter', 20)->unique();
            $table->string('nama_pelanggan');
            $table->text('alamat');
            $table->string('no_telepon', 15);
            $table->foreignId('tarif_id')->constrained('tarifs')->onDelete('cascade');
            $table->decimal('daya', 5, 2);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pelanggans');
    }
};
