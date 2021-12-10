<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMoviesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movies', function (Blueprint $table) {
            $table->id();
            $table->boolean('adult');
            $table->json('belongs_to_collection');
            $table->unsignedBigInteger('budget');
            $table->json('genres');
            $table->string('homepage');
            $table->string('language');
            $table->text('title');
            $table->longText('text');
            $table->unsignedFloat('popularity');
            $table->json('production_companies');
            $table->string('release_date');
            $table->unsignedFloat('vote_average');
            $table->unsignedInteger('vote_count');
            $table->string('tagline', 512);
            $table->string('status');
            $table->unsignedInteger('revenue');
            $table->unsignedInteger('runtime');
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
        Schema::dropIfExists('movies');
    }
}
