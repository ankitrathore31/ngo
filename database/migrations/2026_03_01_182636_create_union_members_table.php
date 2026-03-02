<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUnionMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('union_members', function (Blueprint $table) {
            $table->id();
        $table->foreignId('union_id')->constrained()->onDelete('cascade');
        $table->foreignId('member_id')->constrained()->onDelete('cascade');
        $table->bigInteger('member_by');
        $table->date('join_date');
        $table->date('expiry_date');
        $table->boolean('status')->default(1);
        $table->timestamps();
        $table->unique(['union_id', 'member_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('union_members');
    }
}
