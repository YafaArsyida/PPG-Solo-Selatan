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
        Schema::create('tr_infaq', function (Blueprint $table) {
            $table->id('tr_infaq_id');

            $table->foreignId('ms_kegiatan_id')->nullable();

            $table->foreignId('ms_pengguna_id')->nullable();

            $table->decimal('nominal', 15, 2);
            $table->date('tanggal');

            $table->text('keterangan')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tr_infaq');
    }
};
