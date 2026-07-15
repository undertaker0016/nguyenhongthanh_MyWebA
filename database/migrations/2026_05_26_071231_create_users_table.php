<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();

            $table->string('fullname', 100);
            $table->string('username', 50)->unique();
            $table->string('email', 100)->unique();

            $table->string('password', 255);

            $table->string('phone', 10)->nullable()->unique();

            $table->string('address', 255)->nullable();

            // 0 = chưa chọn, 1 = nam, 2 = nữ
            $table->tinyInteger('gender')->default(0);

            $table->date('birthday')->nullable();

            // 1 = admin, 2 = user
            $table->unsignedTinyInteger('role')->default(2);


            // 1 = active, 0 = block
            $table->tinyInteger('status')->default(1);

            $table->softDeletes();
            $table->rememberToken();

            $table->timestamps();
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
