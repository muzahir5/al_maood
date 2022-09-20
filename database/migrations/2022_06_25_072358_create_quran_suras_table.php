<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuranSurasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quran_suras', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('surah_number');
            $table->integer('aya_number');
            $table->integer('status')->default(1);
            $table->text('arabic_text');
            $table->text('translation');
            $table->integer('read_by');
            $table->text('footnotes');
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
        Schema::dropIfExists('quran_suras');
    }
}