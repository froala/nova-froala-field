<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFroalaAttachmentTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nova_pending_froala_attachments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('draft_id')->index();
            $table->string('attachment');
            $table->string('disk');
            $table->timestamps();
        });

        Schema::create('nova_froala_attachments', function (Blueprint $table) {
            $table->increments('id');
            $table->morphs('attachable');
            $table->string('attachment');
            $table->string('disk');
            $table->string('url')->index();
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
        Schema::drop('nova_pending_froala_attachments');
        Schema::drop('nova_froala_attachments');
    }
}
