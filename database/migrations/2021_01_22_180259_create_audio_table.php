<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id();
            $table->foreignId('user_id');
            $table->string('title')->nullable();
            $table->text('slug')->nullable();
            $table->string('class')->nullable();
            $table->string('category')->nullable();
            $table->string('author')->nullable();
            $table->string('genre')->nullable();
            $table->string('language')->nullable();
            $table->string('lead_character')->nullable();
            $table->string('lead_college')->nullable();
            $table->longText('blurb')->nullable();
            $table->string('cost')->nullable();
            $table->string('content_warning')->nullable();
            $table->string('publish_date')->nullable();
            $table->string('code')->nullable();
            $table->text('review_question_1')->nullable();
            $table->text('review_question_2')->nullable();
            $table->text('front')->nullable();
            $table->longText('credit_page')->nullable();
            $table->text('cover')->nullable();
            $table->text('heat_level')->nullable();
            $table->text('violence_level')->nullable();
            $table->text('age_restriction')->nullable();
            $table->string('free_art')->nullable();
            $table->text('audio')->nullable();
            $table->foreignId('group_id')->nullable();
            $table->timestamp('cpy')->nullable();
            $table->string('approved')->nullable();
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
    }
}
