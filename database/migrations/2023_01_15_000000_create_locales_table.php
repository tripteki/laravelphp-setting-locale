<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLocalesTable extends Migration
{
    /**
     * @return void
     */
    public function up()
    {
        Schema::create("languages", function (Blueprint $table) {

            $table->char("code", 5);

            $table->string("locale");

            $table->primary("code");
        });

        Schema::create("translations", function (Blueprint $table) {

            $table->string("key");
            $table->char("language_code", 5);

            $table->text("translate");

            $table->primary([ "key", "language_code", ]);
            $table->foreign("language_code")->references("code")->on("languages")->onUpdate("cascade")->onDelete("cascade");
        });
    }

    /**
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists("translations");
        Schema::dropIfExists("languages");
    }
};
