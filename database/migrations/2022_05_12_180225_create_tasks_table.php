<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->bigInteger('project_id');
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');;
            $table->bigInteger('status_id');
            $table->foreign('status_id')->references('id')->on('task_statuses');
            $table->bigInteger('created_by_id');
            $table->foreign('created_by_id')->references('id')->on('users');
            $table->date('deadline')->nullable();
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
        Schema::dropIfExists('tasks');
    }
}
