<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('signature', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('user'); // create a column user_id with a type bigInter, from users.id
            $table->string('status_invoice');
            $table->string('description');
            $table->string('amount');
            $table->timestamp('due_date');
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('signature');
    }
};
