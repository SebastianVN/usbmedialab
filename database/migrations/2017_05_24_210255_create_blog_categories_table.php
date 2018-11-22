<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBlogCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blog_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('name_identifier')->unique();
            $table->string('description')->nullable();
            $table->string('main_image')->nullable();
            $table->text('content')->nullable();
            $table->unsignedInteger('total_posts')->default(0);
            $table->unsignedInteger('total_comments')->default(0);
            $table->unsignedInteger('total_views')->default(0);
            $table->unsignedInteger('day_views')->default(0);
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
        Schema::dropIfExists('blog_categories');
    }
}
