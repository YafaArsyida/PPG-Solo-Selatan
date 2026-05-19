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
        Schema::create('ms_pengurus', function (Blueprint $table) {
            $table->id('ms_pengurus_id');
            $table->unsignedBigInteger('ms_kelompok_id'); // FK ke kelompok
            $table->string('nama_pengurus', 150);

            $table->string('kode_pengurus')->nullable()->unique();
            $table->string('telepon')->nullable();

            $table->string('tempat_lahir', 100)->nullable();
            $table->date('tanggal_lahir')->nullable();

            $table->enum('jenis_kelamin', ['laki-laki', 'perempuan'])->nullable();
            $table->text('alamat')->nullable();
            $table->text('deskripsi')->nullable();

            $table->timestamps();
            $table->softDeletes();
            $table->index('ms_kelompok_id');
            $table->index('nama_pengurus');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ms_pengurus');
    }
};
