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
        Schema::create('user_logs', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('label_width');
            $table->string('label_height');
            $table->string('paper_orientation');
            $table->string('paper_size');
            $table->date('date');
            $table->tinyInteger('allow_range');
            $table->string('start_position');
            $table->string('end_position');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_logs');
    }
};
