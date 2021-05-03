<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQueueLoggersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('queue_logs', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->nullable();
            $table->string('connection')->nullable();
            $table->string('task')->nullable();
            $table->string('status')->nullable()->default('pending');
            $table->tinyInteger('processed')->nullable()->default(0);
            $table->dateTime('dispatched_at', 6)->nullable();
            $table->dateTime('started_processing_at', 6)->nullable();
            $table->dateTime('processed_at', 6)->nullable();
            $table->dateTime('failed_at', 6)->nullable();
            $table->longText('command');
            $table->longText('event')->nullable();
            $table->tinyInteger('failed')->nullable()->default(0);
            $table->longText('error_message')->nullable();
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
        Schema::dropIfExists('queue_logs');
    }
}
