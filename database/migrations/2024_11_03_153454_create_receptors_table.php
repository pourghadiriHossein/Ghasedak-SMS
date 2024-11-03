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
        Schema::create('receptors', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('message_id')->nullable();
            $table->string('row')->nullable();
            $table->string('phone')->nullable();
            $table->boolean('status')->default(0);
            $table->timestamps();

            $table->foreign('message_id')
                ->on('messages')
                ->references('id')
                ->nullOnDelete()
                ->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('receptors');
    }
};
