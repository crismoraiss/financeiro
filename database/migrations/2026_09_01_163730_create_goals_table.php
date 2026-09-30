<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goals', function (Blueprint $table) {
            $table->id();

            $table->string('name');

            // Valor que você já possui guardado ao criar a meta
            $table->decimal('initial_amount', 10, 2)->default(0);

            // Quanto você quer acrescentar à reserva
            $table->decimal('target_amount', 10, 2);

            $table->date('deadline')->nullable();

            $table->text('description')->nullable();

            $table->enum('status', [
                'active',
                'completed'
            ])->default('active');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('goals');
    }
};
