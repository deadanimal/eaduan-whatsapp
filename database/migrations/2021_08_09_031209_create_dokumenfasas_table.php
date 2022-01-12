<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDokumenfasasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dokumenfasas', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('nama_dok', 50);
            $table->string('fasa', 50);
            $table->string('nama_fail')->nullable();
            $table->string('laluan_fail')->nullable();
            $table->integer('saiz')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dokumenfasas');
    }
}
