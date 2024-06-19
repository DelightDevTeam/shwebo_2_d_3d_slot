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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('user_name')->unique();
            $table->string('name');
            $table->string('phone')->nullable();
            $table->string('email')->nullable()->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('profile', 2000)->nullable();
            $table->decimal('max_score')->default(0.00);
            $table->integer('status')->default(1);
            $table->integer('gem')->default('0');
            $table->integer('bonus')->default('0');
            $table->integer('limit')->default('500');
            $table->integer('limit3')->default('500');
            $table->integer('cor')->default('5');
            $table->integer('cor3')->default('5');
            $table->float('main_balance')->default(0);
            $table->unsignedBigInteger('agent_id')->nullable();
            $table->timestamp('last_active_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->foreign('agent_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
