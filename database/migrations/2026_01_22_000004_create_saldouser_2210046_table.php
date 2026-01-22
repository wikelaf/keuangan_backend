<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('saldouser_2210046', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('iduser_2210046');
            $table->double('jumlahsaldo_2210046')->default(0);
            $table->timestamps();

            $table->foreign('iduser_2210046')
                ->references('id')->on('users')
                ->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('saldouser_2210046');
    }
};
