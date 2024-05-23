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
        Schema::create('tag_categorie', function (Blueprint $table) {
            $table->increments('id');
            $table->string('color');
            $table->integer('taxononmy_id')->unsigned();
            $table->foreign('taxononmy_id')
                ->references('id')
                ->on('taxonomy')
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
        Schema::dropIfExists('tag_categorie');
    }
};
