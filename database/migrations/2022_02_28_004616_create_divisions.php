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
        Schema::create('divisions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('builder_id')->constrained('builders')->onUpdate('cascade')->onDelete('cascade');
            $table->string('name', 125);
            $table->char('state', 2);
            $table->float('latitude', 125);
            $table->float('longitude', 125);

            $table->timestamps();
            $table->softDeletes();

            // add index
            $table->index(['builder_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('divisions');
    }
};
