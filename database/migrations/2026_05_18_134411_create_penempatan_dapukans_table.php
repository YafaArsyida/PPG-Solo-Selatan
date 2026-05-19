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
        Schema::create('ms_penempatan_dapukan', function (Blueprint $table) {
            $table->id('ms_penempatan_dapukan');

            $table->unsignedBigInteger('ms_pengurus_id');
            $table->unsignedBigInteger('ms_dapukan_id');

            $table->string('nama_penempatan', 150);

            $table->text('deskripsi')->nullable();

            $table->enum('status_aktif', [
                'aktif',
                'nonaktif'
            ])->default('aktif');

            $table->timestamps();

            $table->index('ms_pengurus_id');
            $table->index('ms_dapukan_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ms_penempatan_dapukan');
    }
};
