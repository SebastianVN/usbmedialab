<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBlogPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blog_posts', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('blogger_id');
            $table->unsignedInteger('category_id')->nullable();
            $table->string('name');
            $table->string('name_identifier')->unique();
            $table->string('description')->nullable();
            $table->string('main_image')->nullable();
            $table->string('header_type')->nullable();
            $table->text('header_data')->nullable();
            $table->text('content')->nullable();
            $table->unsignedInteger('total_comments')->default(0);
            $table->unsignedInteger('total_views')->default(0);
            $table->unsignedInteger('day_views')->default(0);
            $table->unsignedInteger('total_words')->default(0);
            $table->unsignedInteger('total_chars')->default(0);
            $table->unsignedInteger('total_rank')->default(0);
            $table->enum('status', ['waiting_approval', 'approved_unavailable', 'approved_available', 'not_approved', 'needs_revision']);
            $table->text('notes')->nullable();
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
        Schema::dropIfExists('blog_posts');
    }
}
