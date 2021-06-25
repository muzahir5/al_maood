<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAudioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('audio', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->text('description')->nullable();
            $table->integer('status')->default(0);
            $table->integer('category');
            $table->integer('show_to');
            $table->string('poet')->nullable();
            $table->string('narrator')->nullable();
            $table->string('duration')->nullable();
            $table->string('audio_url');
            $table->string('released_at')->nullable();
            $table->string('album')->nullable();
            $table->string('upload_by');
            $table->integer('upload_by_id');
            $table->string('img_upload_text_link')->nullable();
            $table->string('pdf_upload_text_link')->nullable();
            $table->bigInteger('view_by')->nullable();
            $table->timestamps();
        });

        Schema::create('video', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->text('description')->nullable();
            $table->integer('status')->default(0);
            $table->integer('category');
            $table->integer('show_to');
            $table->string('poet')->nullable();
            $table->string('narrator')->nullable();
            $table->string('duration')->nullable();
            $table->string('video_url');
            $table->string('album')->nullable();
            $table->string('released_at')->nullable();
            $table->string('upload_by');
            $table->integer('upload_by_id');
            $table->string('img_upload_text_link')->nullable();
            $table->string('pdf_upload_text_link')->nullable();
            $table->bigInteger('view_by')->nullable();
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
        Schema::dropIfExists('audio');
        Schema::dropIfExists('video');
    }
}
