<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('receivables', function (Blueprint $table) {
            $table->id();

            $table->string('person_name');
            $table->string('description');
            $table->decimal('amount', 10, 2);

            $table->date('due_date')->nullable();
            $table->date('received_at')->nullable();

            $table->enum('status', ['pending', 'received'])
                ->default('pending');

            $table->text('observation')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('receivables');
    }
};
