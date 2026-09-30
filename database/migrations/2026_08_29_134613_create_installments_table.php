<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('installments', function (Blueprint $table) {
            $table->id();

            $table->string('description');
            $table->string('card_name')->nullable();

            $table->decimal('installment_amount', 10, 2);

            $table->unsignedInteger('total_installments');
            $table->unsignedInteger('paid_installments')->default(0);

            $table->unsignedTinyInteger('due_day');

            $table->date('first_due_date');

            $table->enum('status', [
                'active',
                'finished'
            ])->default('active');

            $table->text('observation')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('installments');
    }
};
