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
        Schema::create('itinerary', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('description');
            $table->string('type');
            $table->double('length');
            $table->decimal('positive_drop', 8, 2);
            $table->decimal('negative_drop', 8, 2);
            $table->double('estimated_time');
            $table->double('difficulty');
            $table->string('source');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')
                ->references('id')
                ->on('user')
                ->onDelete('restrict')
                ->onUpdate('restrict');
            $table->integer('image_id')->unsigned();
            $table->foreign('image_id')
                ->references('id')
                ->on('image')
                ->onDelete('restrict')
                ->onUpdate('restrict');
            $table->string('pdf_url');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('itinerary');
    }
};
