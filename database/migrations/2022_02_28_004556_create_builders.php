<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('builders', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('email', 225);
            $table->string('phone', 15);
            $table->string('address', 225);
            $table->string('address2', 125)->nullable();
            $table->string('city', 125);
            $table->char('state', 2)->default('FL');
            $table->string('zip', 10);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('builders');
    }
};
