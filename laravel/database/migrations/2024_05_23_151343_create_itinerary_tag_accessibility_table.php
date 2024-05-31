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
        Schema::create('itinerary_tag_accessibility', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('tag_accessibility_id')->unsigned();
            $table->foreign('tag_accessibility_id')
                ->references('id')
                ->on('tag_accessibilities')
                ->onDelete('restrict')
                ->onUpdate('restrict');
            $table->integer('itinerary_id')->unsigned();
            $table->foreign('itinerary_id')
                ->references('id')
                ->on('itineraries')
                ->onDelete('restrict')
                ->onUpdate('restrict');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('itinerary_tag_accessibility');
    }
};
