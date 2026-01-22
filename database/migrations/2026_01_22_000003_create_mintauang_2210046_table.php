<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('mintauang_2210046', function (Blueprint $table) {
            $table->char('noref_2210046', 50)->primary();
            $table->timestamp('tglminta_2210046')->nullable()->useCurrent();
            $table->unsignedBigInteger('dari_iduser_2210046')->nullable();
            $table->unsignedBigInteger('ke_iduser_2210046')->nullable();
            $table->double('jumlahuang_2210046')->nullable();
            $table->enum('stt_2210046', ['pending', 'sukses'])->nullable();
            $table->timestamp('tglsukses_2210046')->nullable();

            $table->foreign('dari_iduser_2210046')
                ->references('id')->on('users')
                ->onUpdate('cascade');

            $table->foreign('ke_iduser_2210046')
                ->references('id')->on('users')
                ->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mintauang_2210046');
    }
};
