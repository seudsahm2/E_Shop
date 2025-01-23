<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropUserGrowthsTable extends Migration
{
    public function up()
    {
        Schema::dropIfExists('user_growths');
    }

    public function down()
    {
        // Optionally, you can recreate the table here if needed in the future
        Schema::create('user_growths', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }
}