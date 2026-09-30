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
        Schema::create('goal_transactions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('goal_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->enum('type', [
                'deposit',
                'withdrawal'
            ]);

            $table->decimal('amount', 10, 2);

            $table->date('transaction_date');

            $table->text('observation')->nullable();

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
        Schema::dropIfExists('goal_transactions');
    }
};
