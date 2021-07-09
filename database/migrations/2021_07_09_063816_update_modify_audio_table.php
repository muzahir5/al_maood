<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateModifyAudioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('audio', function ($table) {            
            $table->string('type')->after('category')->nullable();
            $table->string('language')->after('type')->nullable();
            $table->renameColumn('img_upload_text_link', 'audio_img');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $table->dropColumn('type');
        $table->dropColumn('language');
        $table->renameColumn('audio_img', 'img_upload_text_link');
    }
}
