<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSharePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('share_posts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('from_u_id');
            $table->integer('to_u_id');
            $table->integer('post_id');
            $table->string('post_type');
            $table->boolean('is_viewed')->default(0);
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
        Schema::dropIfExists('share_posts');
    }
}
