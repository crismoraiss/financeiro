<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('expenses', function (Blueprint $table) {

            $table->foreignId('installment_id')
                ->nullable()
                ->after('category_id')
                ->constrained('installments')
                ->nullOnDelete();

        });
    }

    public function down(): void
    {
        Schema::table('expenses', function (Blueprint $table) {
            $table->dropForeign(['installment_id']);
            $table->dropColumn('installment_id');
        });
    }
};
