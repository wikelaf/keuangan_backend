<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('kas_2210046', function (Blueprint $table) {
            $table->char('notrans_2210046', 50)->primary();
            $table->date('tanggal_2210046');
            $table->double('jumlahuang_2210046')->default(0);
            $table->string('keterangan_2210046', 255);
            $table->enum('jenis_2210046', ['masuk', 'keluar']);
            $table->unsignedBigInteger('iduser_2210046');
            $table->timestamps();

            $table->foreign('iduser_2210046')
                ->references('id')->on('users')
                ->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kas_2210046');
    }
};
