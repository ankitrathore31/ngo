<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();;
            $table->string('file_name')->nullable();;
            $table->string('file_path');
            $table->string('file_type')->nullable();; // pdf, jpg, png, etc.
            $table->string('file_size')->nullable();; // in KB
            $table->text('description')->nullable();
            $table->integer('download_count')->default(0);
            $table->boolean('is_active')->default(1);
            $table->foreignId('uploaded_by')->constrained('users')->onDelete('cascade');
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
        Schema::dropIfExists('documents');
    }
}
