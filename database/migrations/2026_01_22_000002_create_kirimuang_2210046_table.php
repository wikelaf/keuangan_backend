<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('kirimuang_2210046', function (Blueprint $table) {
            $table->char('noref_2210046', 50)->primary();
            $table->timestamp('tglkirim_2210046')->useCurrent();
            $table->unsignedBigInteger('dari_iduser_2210046');
            $table->unsignedBigInteger('ke_iduser_2210046');
            $table->double('jumlahuang_2210046')->default(0);

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
        Schema::dropIfExists('kirimuang_2210046');
    }
};
