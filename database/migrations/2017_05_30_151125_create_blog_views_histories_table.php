<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBlogViewsHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blog_views_histories', function (Blueprint $table) {
            $table->increments('id');
            $table->date('fecha');
            $table->enum('type', ['post', 'category', 'blogger', 'blog']);
            $table->unsignedInteger('identifier');
            $table->unsignedInteger('views');
            $table->unique(['fecha', 'type', 'identifier']);
            $table->string('notes')->nullable();
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
        Schema::dropIfExists('blog_views_histories');
    }
}
