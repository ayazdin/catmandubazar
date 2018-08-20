<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('userid')->nullable();
            $table->text('title');
            $table->string('name')->nullable();
            $table->text('excerpt')->nullable();
            $table->text('content')->nullable();
            $table->text('clean_url');
            $table->string('ctype')->nullable();
            $table->string('image')->nullable();
            $table->integer('menu_order')->nullable();
            $table->integer('cmt_count')->nullable();
            $table->string('status')->nullable();
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
        Schema::dropIfExists('posts');
    }
}
