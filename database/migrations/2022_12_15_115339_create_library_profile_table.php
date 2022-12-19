<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLibraryProfileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('library_profile', function (Blueprint $table) {
            $table->id();
            $table->text("mission")->nullable();
            $table->text("vision")->nullable();
            $table->text("rules_regulation")->nullable();
            $table->text("school_history")->nullable();
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
        Schema::dropIfExists('library_profile');
    }
}
